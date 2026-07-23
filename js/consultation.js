const phoneInput = document.querySelector("#phone");
const iti = intlTelInput(phoneInput, {
    initialCountry: "us",
    preferredCountries: ["us", "gb", "ca", "au", "in"],
    separateDialCode: true,
    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
});

function toggleOtherService() {
    const serviceSelect = document.getElementById("service");
    const otherServiceGroup = document.getElementById("other-service-group");
    const otherServiceInput = document.getElementById("other_service");
    
    if (serviceSelect.value === "Other") {
        otherServiceGroup.style.display = "block";
        otherServiceInput.required = true;
    } else {
        otherServiceGroup.style.display = "none";
        otherServiceInput.required = false;
        otherServiceInput.value = "";
    }
}
