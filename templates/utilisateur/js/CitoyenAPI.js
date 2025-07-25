class CitoyenAPI {
  static BASE_URL = "https://appdaf-g15c.onrender.com/api";

  static async fetchCitoyen(cni) {
    console.log("Fetching citizen data for CNI:", cni);
    try {
      const response = await fetch(`${this.BASE_URL}/citoyen/${cni}`);
      console.log("Raw response:", response);

      const result = await response.json();
      console.log("Parsed response:", result);

      if (!result || result.code !== 200 || !result.data) {
        console.error("Invalid response format:", result);
        throw new Error("Citoyen non trouvé");
      }

      return result.data;
    } catch (error) {
      console.error("Error in fetchCitoyen:", error);
      throw error;
    }
  }

  static formatCitoyenData(data) {
    console.log("Formatting citizen data:", data);
    const formatted = {
      prenom: data.prenom || "",
      nom: data.nom || "",
      email: data.email || "",
      telephone: data.telephone || data.phone || "",
      rectoUrl: data.url_carte_recto || "",
      versoUrl: data.url_carte_verso || "",
      dateNaissance: data.date || "Non disponible",
      lieuNaissance: data.lieu || "Non disponible",
    };
    console.log("Formatted data:", formatted);
    return formatted;
  }
}
