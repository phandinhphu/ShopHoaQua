var inputLabels = document.querySelectorAll(".input__label");
var inputTexts = document.querySelectorAll(".input__text");
inputTexts.forEach((inputText, index) => {
    inputText.addEventListener("focus", () => {
        inputLabels[index].classList.add("active");
        inputText.setAttribute("style",`
                                border: 1px solid #ccc;
                                border-radius: 8px;
                                `);
    });

    inputText.addEventListener("blur", () => {
    if (inputText.value === "") {
        inputLabels[index].classList.remove("active");
        inputText.setAttribute("style",`
                                border-bottom: 1px solid #ccc;
                                `);
    }
    });
});
