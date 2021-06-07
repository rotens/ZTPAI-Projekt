const accountName = document.querySelector('.user-select');
const groupBy = document.querySelector('.groupby-select');
const generateButton = document.querySelector('.statistics-form button');
const resultsContainerH1 = document.querySelector('.results-container h1');
const statisticsTable = document.querySelector('.results-table-container table');
const resultsContainer = document.querySelector('.results-container');

const EN_PL = {
    "year": "Rok",
    "month": "Miesiąc",
    "day": "Dzień",
    "weekday": "Dzień tygodnia",
    "hour": "Godzina",
}

generateButton.addEventListener("click", function (event) {

    let link = createStatisticsGetLink(accountName.value, groupBy.value);

    fetch(link, {
        method: "GET"
    }).then(function (response) {
        return response.json();
    }).then(function (stats) {
        console.log(stats);

        resultsContainerH1.innerText = "Statystyki";
        statisticsTable.innerHTML = "";

        if (statisticsTable.querySelector("tr") == null) {
            createTableHeader();
        }

        loadStats(stats["hydra:member"]);
        
    });
});

function createTableHeader() {
    let splittedGroupBy = groupBy.value.split("_");
    const tr = document.createElement("tr");
    let th;

    splittedGroupBy.forEach(el => {
        th = document.createElement("th");
        th.innerHTML = EN_PL[el];
        tr.appendChild(th);
    });

    th = document.createElement("th");
    th.innerHTML = "Liczba postów";
    tr.appendChild(th);

    statisticsTable.appendChild(tr);;
}

function loadStats(stats) {
    stats.forEach(row => {
        createRow(row);
    });
}

function createRow(row) {
    const tr = document.createElement("tr");
    let td;

    row["groupedBy"].forEach(el => {
        td = document.createElement("td");
        td.innerHTML = el;
        tr.appendChild(td)
    });

    td = document.createElement("td");
    td.innerHTML = row["numberOfMessages"];
    tr.appendChild(td);

    statisticsTable.appendChild(tr);
}

function createStatisticsGetLink(accountName, groupBy) {
    let string = "api/statistics?page=1";

    if (accountName)
        string += `&account_name=${accountName}`;

    if (groupBy)
        string += `&groupby=${groupBy}`;

    return string;
}
