import "./bootstrap";
import Alpine from "alpinejs";

window.Alpine = Alpine;
Alpine.start();

const intl_currency = new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
    maximumFractionDigits: 0,
    minimumFractionDigits: 0,
});

window.format_currency = (nominal) => {
    const formatted_currency = intl_currency.format(nominal);
    return formatted_currency;
};

window.toggle_hidden_input_element = (e, targetId) => {
    const fieldsetElement = document.getElementById("fieldset-" + targetId);
    const inputElement = document.getElementById("input-" + targetId);
    if (e.checked) {
        fieldsetElement.hidden = false;
        inputElement.required = true;
    } else {
        fieldsetElement.hidden = true;
        inputElement.required = false;
    }
};

window.render_currency_to = (input, targetId) => {
    const el = document.getElementById(targetId);
    el.innerHTML = window.format_currency(input.value);
};

window.open_modal = (modalId) => {
    const modal = document.getElementById(modalId);
    modal.showModal();
};

window.close_modal = (modalId) => {
    const modal = document.getElementById(modalId);
    modal.close();
};
