class UIHelper {
  static async showCustomPopup(
    title,
    message,
    type = "info",
    showCancel = false
  ) {
    return new Promise((resolve) => {
      const elements = {
        modal: document.getElementById("customModal"),
        title: document.getElementById("modalTitle"),
        message: document.getElementById("modalMessage"),
        icon: document.getElementById("modalIcon"),
        confirm: document.getElementById("modalConfirm"),
        cancel: document.getElementById("modalCancel"),
      };

      elements.title.textContent = title;
      elements.message.textContent = message;

      this.setModalIcon(elements.icon, type);
      this.toggleCancelButton(elements.cancel, showCancel);

      elements.modal.classList.remove("hidden");

      const cleanup = () => {
        elements.modal.classList.add("hidden");
        elements.confirm.removeEventListener("click", confirmHandler);
        elements.cancel.removeEventListener("click", cancelHandler);
        document.removeEventListener("keydown", escapeHandler);
      };

      const confirmHandler = () => {
        cleanup();
        resolve(true);
      };

      const cancelHandler = () => {
        cleanup();
        resolve(false);
      };

      const escapeHandler = (e) => {
        if (e.key === "Escape") {
          cleanup();
          resolve(false);
        }
      };

      elements.confirm.addEventListener("click", confirmHandler);
      elements.cancel.addEventListener("click", cancelHandler);
      document.addEventListener("keydown", escapeHandler);
    });
  }

  static setModalIcon(iconElement, type) {
    const icons = {
      warning:
        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.134 16.5c-.77.833.192 2.5 1.732 2.5z"></path>',
      error:
        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>',
      info: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
    };

    iconElement.innerHTML = icons[type] || icons.info;
  }

  static toggleCancelButton(cancelButton, show) {
    if (show) {
      cancelButton.classList.remove("hidden");
    } else {
      cancelButton.classList.add("hidden");
    }
  }
}
