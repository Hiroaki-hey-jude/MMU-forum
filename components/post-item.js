class PostItem extends HTMLElement {
  constructor() {
    super();
  }

  connectedCallback() {
    // type can be post or subcategory
    const type = this.getAttribute("type") ?? "post";
    const title = this.getAttribute("title") ?? "&nbsp"; // &nbsp adds a space so it retains the styling when <p> is empty
    const href = this.getAttribute("href") ?? "";
    const likes = this.getAttribute("likes") ?? 0;
    const comments = this.getAttribute("comments") ?? 0;
    const author = this.getAttribute("author")
      ? "by " + this.getAttribute("author")
      : "";
    const createdAt = this.getAttribute("createdAt") ?? "";
    const pinned = this.getAttribute("pinned")
      ? `<span class="fas fa-bookmark" style="float: right; margin: 0.5em 0.5em 0 0;"></span>`
      : ``;

    const posts = this.getAttribute("posts") ?? 0;
    this.innerHTML = `
      <link rel="stylesheet" href="../css/global.css" />
      <script src="js/moment.js"></script>
      <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
      <div class="post-item" onclick="location.href = '${href}';">
          ${type === "post" ? pinned : ""}
          <p class="list-item-title">${title}</p>
          <div class="list-item-subtitle">
            ${
              type === "subcategory"
                ? `<a class="post-action"><span class="post-action-icon fas fa-list"></span> ${posts}</a>`
                : `<a class="post-action"><span class="post-action-icon fas fa-thumbs-up"></span> ${likes}</a>`
            }
            <a class="post-action"><span class="post-action-icon fas fa-comments"></span> ${comments}</a>
            <span style="flex: 1"></span>
            ${
              type === "post"
                ? `<div style="color: gray; font-size: small;">${author} ${createdAt}</div>`
                : ""
            }
          </div>
      </div>
    `;
  }
}

customElements.define("post-item", PostItem);
