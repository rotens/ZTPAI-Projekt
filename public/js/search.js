const accountName = document.querySelector('.user-select');
const dateFrom = document.querySelector('.search-form input[name="form[start_date]"');
const dateTo = document.querySelector('.search-form input[name="form[end_date]"');
const searchedString = document.querySelector('.search-form input[name="form[search_input]"]');
const searchButton = document.querySelector('.search-form button');
const resultsContainerH1 = document.querySelector('.results-container h1');
const messagesTable = document.querySelector('.results-table-container table');
const resultsContainer = document.querySelector('.results-container');
const paginationDiv = document.querySelector('.pagination');
const nextPage = document.querySelector('#next');
const previousPage = document.querySelector('#previous');
let currentPage = 1;

searchButton.addEventListener("click", function (event) {
    currentPage = 1;
    search();
});

nextPage.addEventListener("click", function(event) {
    currentPage += 1;
    search();
});

previousPage.addEventListener("click", function(event) {
    currentPage -= 1;
    search();
});

function search() {
    const data = {
        accountName: accountName.value,
        dateFrom: dateFrom.value,
        dateTo: dateTo.value,
        searchedString: searchedString.value
    };

    let link = createSearchGetLink(data, currentPage);

    fetch(link, {
        method: "GET"
    }).then(function (response) {
        return response.json();
    }).then(function (messages) {
        console.log(messages);

        resultsContainerH1.innerText = "Wyniki wyszukiwania"
        messagesTable.innerHTML = "";

        if (messagesTable.querySelector("tr") == null)
        {
            const tableHeaderTemplate = document.querySelector("#table-header-template");
            const clone = tableHeaderTemplate.content.cloneNode(true);
            messagesTable.appendChild(clone);
        }

        loadMessages(messages["hydra:member"]);
        pagination(messages["hydra:view"]);
    });
}

function loadMessages(messages) {
    messages.forEach(message => {
        createMessage(message);
    });
}

function createMessage(message) {
    const template = document.querySelector("#message-template");

    const clone = template.content.cloneNode(true);
    const user = clone.querySelector("td:nth-child(1)");
    user.innerText = message["account_name"];
    const date = clone.querySelector("td:nth-child(2)");
    date.innerText = transformDateString(message["date"]);
    const message_content = clone.querySelector("td:nth-child(3)");
    message_content.innerText = message["message"];

    messagesTable.appendChild(clone);
}

function pagination(arg) {
    let lastPage = parseInt(arg["hydra:last"].slice(-1));

    paginationDiv.style = "display: block";
    paginationDiv.children["1"].innerHTML = currentPage;
    paginationDiv.children["3"].innerHTML = lastPage;

    if (currentPage == 1) {
        previousPage.style="display: none";
    } else {
        previousPage.style="display: inline";
    }

    if (currentPage == lastPage) {
        nextPage.style="display: none";
    } else {
        nextPage.style="display: inline";
    }

    console.log(paginationDiv);
}

function createSearchGetLink(data, page=1) {
    let string = `api/searches?page=${page}`;

    if (data.accountName)
        string += `&account_name=${data.accountName}`;

    if (data.dateFrom)
        string += `&dateFrom=${data.dateFrom}`;

    if (data.dateTo)
        string += `&dateTo=${data.dateTo}`;

    if (data.searchedString)
        string += `&message=${data.searchedString}`;

    return string;
}

function transformDateString(date) {
    return date.replace("T", " ").slice(0, 19);
}