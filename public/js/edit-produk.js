const uploadArea = document.getElementById("upload-area");
const fileInput = document.getElementById("gambar");
const imagePreview = document.getElementById("image-preview");
const uploadPlaceholder = document.getElementById("upload-placeholder");

uploadArea.addEventListener("click", () => fileInput.click());

uploadArea.addEventListener("dragover", (e) => {
    e.preventDefault();
    uploadArea.style.background = "#f0f0f0";
});

uploadArea.addEventListener("dragleave", () => {
    uploadArea.style.background = "";
});

uploadArea.addEventListener("drop", (e) => {
    e.preventDefault();
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        fileInput.files = files;
        handleFileSelect();
    }
});

fileInput.addEventListener("change", handleFileSelect);

function handleFileSelect() {
    const file = fileInput.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            imagePreview.src = e.target.result;
            imagePreview.style.display = "block";
            uploadPlaceholder.style.display = "none";
        };
        reader.readAsDataURL(file);
    }
}
