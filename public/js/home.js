const removeButtons = document.querySelectorAll('.remove');

removeButtons.forEach(item => {
    item.addEventListener('click', event => {

        let postContainer = item.parentNode.parentNode;
        let postId = postContainer.querySelector('input');

        let link = "/api/posts/" + postId.value;

        fetch(link, {
            method: "DELETE",
        }).then(function (response) {
            if (response.status === 204) {
                postContainer.remove();
            }
        });
    });
});