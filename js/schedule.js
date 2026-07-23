const phoneInput = document.querySelector("#phone");
const iti = intlTelInput(phoneInput, {
    initialCountry: "us",
    preferredCountries: ["us", "gb", "ca", "au", "in"],
    separateDialCode: true,
    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
});

function toggleOtherTopic() {
    const topicSelect = document.getElementById("topic");
    const otherTopicGroup = document.getElementById("other-topic-group");
    const otherTopicInput = document.getElementById("other_topic");
    
    if (topicSelect.value === "Other") {
        otherTopicGroup.style.display = "block";
        otherTopicInput.required = true;
    } else {
        otherTopicGroup.style.display = "none";
        otherTopicInput.required = false;
        otherTopicInput.value = "";
    }
}
