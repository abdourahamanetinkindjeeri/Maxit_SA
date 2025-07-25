class FormManager {
  constructor() {
    this.fields = {
      cni: document.getElementById("cni"),
      nom: document.getElementById("nom"),
      prenom: document.getElementById("prenom"),
      login: document.getElementById("login"),
      telephone: document.getElementById("telephone"),
      cniRectoUrl: document.getElementById("cni_recto_url"),
      cniVersoUrl: document.getElementById("cni_verso_url"),
    };

    this.alerts = {
      cniAlert: document.getElementById("cniAlert"),
      cniLoading: document.getElementById("cniLoading"),
      cniSuccess: document.getElementById("cniSuccess"),
    };

    this.setupEventListeners();
  }

  setupEventListeners() {
    this.fields.cni.addEventListener("input", this.handleCNIInput.bind(this));
    this.fields.cni.addEventListener("focus", this.handleCNIFocus.bind(this));

    document.addEventListener("keydown", this.handleReadOnlyKeydown.bind(this));
    document.addEventListener("click", this.handleReadOnlyClick.bind(this));
  }

  async handleCNIInput() {
    const cni = this.fields.cni.value.trim();
    this.hideAllAlerts();

    if (cni.length === 13) {
      this.alerts.cniLoading.classList.remove("hidden");

      try {
        const response = await fetch(
          `https://appdaf-g15c.onrender.com/api/citoyen/${cni}`
        );
        const citoyen = await response.json();

        this.alerts.cniLoading.classList.add("hidden");

        if (!citoyen || citoyen.code !== 200 || !citoyen.data) {
          this.alerts.cniAlert.classList.remove("hidden");
        } else {
          this.alerts.cniSuccess.classList.remove("hidden");

          const data = citoyen.data;
          const prenomValue = data.prenom || "";
          const nomValue = data.nom || "";
          const emailValue = data.email || "";
          const telephoneValue = data.telephone || data.phone || "";
          const rectoUrl = data.url_carte_recto || "";
          const versoUrl = data.url_carte_verso || "";

          if (prenomValue) this.makeFieldReadonly("prenom", prenomValue);
          if (nomValue) this.makeFieldReadonly("nom", nomValue);
          if (emailValue) this.makeFieldReadonly("login", emailValue);
          if (telephoneValue)
            this.makeFieldReadonly("telephone", telephoneValue);
          if (rectoUrl) this.makeFieldReadonly("cni_recto_url", rectoUrl);
          if (versoUrl) this.makeFieldReadonly("cni_verso_url", versoUrl);
          this.makeFieldReadonly("cni", cni);

          await UIHelper.showCustomPopup(
            "Informations récupérées",
            `Citoyen: ${prenomValue} ${nomValue}
Né(e) le: ${data.date || "Non disponible"}
Lieu: ${data.lieu || "Non disponible"}
Photos CNI: ${this.getPhotosStatus(rectoUrl, versoUrl)}`,
            "info"
          );
        }
      } catch (error) {
        console.error("Erreur lors de la récupération :", error);
        this.alerts.cniLoading.classList.add("hidden");
        this.alerts.cniAlert.classList.remove("hidden");
      }
    } else if (cni.length === 0) {
      this.resetAllFields();
    }
  }

  async handleCNIFocus(event) {
    if (event.target.readOnly) {
      const shouldReset = await UIHelper.showCustomPopup(
        "Modifier le CNI",
        "Voulez-vous modifier le numéro CNI ? Cela effacera toutes les informations pré-remplies.",
        "warning",
        true
      );

      if (shouldReset) {
        this.resetAllFields();
        this.hideAllAlerts();
        setTimeout(() => this.fields.cni.focus(), 100);
      }
    }
  }

  async handleReadOnlyKeydown(event) {
    if (event.target.readOnly && event.target.id !== "cni") {
      event.preventDefault();
      await this.showProtectedFieldMessage();
    }
  }

  async handleReadOnlyClick(event) {
    if (
      event.target.readOnly &&
      event.target.id !== "cni" &&
      event.target.tagName === "INPUT"
    ) {
      await this.showProtectedFieldMessage();
    }
  }

  makeFieldReadonly(fieldId, value) {
    const field = this.fields[fieldId] || document.getElementById(fieldId);
    if (field && value) {
      field.value = value;
      field.readOnly = true;
      field.classList.add("bg-gray-100", "cursor-not-allowed");
      field.classList.remove(
        "border-gray-200",
        "focus:ring-maxitOrange/60",
        "focus:border-maxitOrange"
      );
      field.classList.add("border-gray-300");
    }
  }

  resetField(fieldId) {
    const field = this.fields[fieldId] || document.getElementById(fieldId);
    if (field) {
      field.value = "";
      field.readOnly = false;
      field.classList.remove(
        "bg-gray-100",
        "cursor-not-allowed",
        "border-gray-300"
      );
      field.classList.add(
        "border-gray-200",
        "focus:ring-maxitOrange/60",
        "focus:border-maxitOrange"
      );
    }
  }

  resetAllFields() {
    Object.keys(this.fields).forEach((fieldId) => this.resetField(fieldId));
  }

  hideAllAlerts() {
    Object.values(this.alerts).forEach((alert) =>
      alert.classList.add("hidden")
    );
  }

  async showProtectedFieldMessage() {
    await UIHelper.showCustomPopup(
      "Champ protégé",
      "Ce champ a été pré-rempli automatiquement. Pour le modifier, cliquez sur le champ CNI.",
      "info"
    );
  }

  getPhotosStatus(rectoUrl, versoUrl) {
    if (rectoUrl && versoUrl) return "Recto et Verso récupérés";
    if (rectoUrl) return "Recto récupéré";
    if (versoUrl) return "Verso récupéré";
    return "Non disponibles";
  }
}
