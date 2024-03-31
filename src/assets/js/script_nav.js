const allCategories = document.getElementById("all-categories");
const categoriesBtn = document.querySelector(".categories-btn");
const categoriesPanel = document.querySelector(".categories-panel");

categoriesBtn.addEventListener("mouseenter", () => {
  categoriesPanel.style.display = "flex";
});

categoriesBtn.addEventListener("mouseleave", () => {
  categoriesPanel.style.display = "none";
});

categoriesPanel.addEventListener("mouseenter", () => {
  categoriesPanel.style.display = "flex";
});
categoriesPanel.addEventListener("mouseleave", () => {
  categoriesPanel.style.display = "none";
});
