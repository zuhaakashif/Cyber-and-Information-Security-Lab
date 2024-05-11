var textOnlyModeToggle = document.getElementById("icontextonly");
var images = document.querySelectorAll("img");

// List of image names to exempt
var exemptedImageNames = ["textmode3.png", "sun.png", "moon.png", "logo.png"]; // Add the names of the images you want to exempt

textOnlyModeToggle.addEventListener("click", function() {
    // Toggle visibility of images
    images.forEach(function(image) {
        // Check if the image should be exempted from hiding
        if (!exemptedImageNames.includes(image.src.split('/').pop())) {
            image.classList.toggle("hidden");
        }
    });
});
