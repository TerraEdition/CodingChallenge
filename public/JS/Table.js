const container = $("*").find(".table-responsive");

let isDown = false;
let startX;
let scrollLeft;

[...container].forEach((table) => {
  table.addEventListener("mousedown", (e) => {
    table.style.cursor = "w-resize";
    isDown = true;
    startX = e.pageX - table.offsetLeft;
    scrollLeft = table.scrollLeft;
  });
  table.addEventListener("mouseleave", () => {
    isDown = false;
    table.style.cursor = "pointer";
  });
  table.addEventListener("mouseup", () => {
    isDown = false;
    table.style.cursor = "pointer";
  });
  table.addEventListener("mousemove", (e) => {
    if (!isDown) return;
    table.style.cursor = "w-resize";
    e.preventDefault();
    const x = e.pageX - table.offsetLeft;
    const walk = x - startX;

    table.scrollLeft = scrollLeft - walk;
  });
});
