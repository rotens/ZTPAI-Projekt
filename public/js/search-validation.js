function validateDate(dateElement)
{
    setTimeout(function() {
        markValidation(dateElement, isValidDate(dateElement.value))
    }, 
    1000);
}

function markValidation(element, condition) {
    if (!condition)
    {
        element.classList.add("not-valid");
        searchButton.disabled = true;
    }
    else
    {
        element.classList.remove("not-valid");
        searchButton.disabled = false;
    }
}

function isValidDate(dateString)
{
    let splitString = dateString.split(' ');

    if (splitString.length > 2)
    {
        return false;
    }
    else
    {
        if (splitString[0] == "")
            return true;

        if(!/^\d{4}-\d{1,2}-\d{1,2}$/.test(splitString[0]))
            return false;
            
        if (splitString.length == 2)
            if (!/^([0-1]?[0-9]|2[0-3]):([0-5][0-9])(:[0-5][0-9])?$/.test(splitString[1]))
                return false;
    }
  
    let parts = splitString[0].split("-");
    let day = parseInt(parts[2], 10);
    let month = parseInt(parts[1], 10);
    let year = parseInt(parts[0], 10);

    if(year < 1000 || year > 3000 || month == 0 || month > 12)
        return false;

    let monthLength = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

    if(year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
        monthLength[1] = 29;

    return day > 0 && day <= monthLength[month - 1];
};

dateFrom.addEventListener('keyup', function() { validateDate(dateFrom) });
dateTo.addEventListener('keyup', function() { validateDate(dateTo) });