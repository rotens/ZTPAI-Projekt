const postContent = document.querySelector('.post-content');
const postTitle = document.querySelector('.post-title');
const editButton = document.querySelector('.edit');
const removeButton = document.querySelector('.remove');
const confirmButton = document.querySelector('.confirm');
const undoButton = document.querySelector('.undo');
const post = document.querySelector('.post');
const postBottom = document.querySelector('.post-bottom');
const postId = document.querySelector('.postid');
let form;
let titleInput;
let contentTextArea;

editButton.addEventListener("click", function (event) {
    postContent.style = "display: none";
    postTitle.style = "display: none";
    editButton.style = "display: none";
    removeButton.style = "display: none";

    undoButton.style = "display: inline";
    confirmButton.style = "display: inline";

    form = document.createElement("form");
    form.classList.add('post-form');

    titleInput = document.createElement("input");
    titleInput.classList.add('title-input');
    titleInput.value = postTitle.textContent;

    contentTextArea = document.createElement("textarea");
    contentTextArea.classList.add('content-textarea');
    contentTextArea.textContent = postContent.textContent;

    form.appendChild(titleInput);
    form.appendChild(contentTextArea);

    post.insertBefore(form, postBottom);

});

undoButton.addEventListener("click", function (event) {
    form.remove();
    postContent.style = "display: block";
    postTitle.style = "display: block";
    editButton.style = "display: inline";
    removeButton.style = "display: inline";

    undoButton.style = "display: none";
    confirmButton.style = "display: none";
});

confirmButton.addEventListener("click", function (event) {
    const data = {
        "title": titleInput.value.trim(" "),
        "content": contentTextArea.value.trim(" ")
    };

    let link = "/api/posts/" + postId.value;

    fetch(link, {
        method: "PUT",
        headers: {
            'Content-Type': 'application/ld+json',
            'accept': 'application/ld+json'
        },
        body: JSON.stringify(data)
    }).then(function (response) {
        return response.json();
    }).then(function (post) {

        form.remove();

        postTitle.textContent = post.title;
        postContent.textContent = post.content;

        postContent.style = "display: block";
        postTitle.style = "display: block";
        editButton.style = "display: inline";
        removeButton.style = "display: inline";

        undoButton.style = "display: none";
        confirmButton.style = "display: none";
    });

    
});
