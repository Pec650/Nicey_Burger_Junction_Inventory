let showDropdown = false;

const profileButton = document.getElementById("profile-button");
profileButton.addEventListener('click', () => {
    const dropdown = document.getElementById("profile-drop-down");
    showDropdown = !showDropdown;
    if (showDropdown) {
        dropdown.style.height = "340px";
        dropdown.style.opacity = "100";
    } else {
        dropdown.style.height = "0";
        dropdown.style.opacity = "0";
    }
});