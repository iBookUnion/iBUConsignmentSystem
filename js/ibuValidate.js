function validateFormGroups(formGroupSelector) {
    var isFormValid = true;

    resetValidation(formGroupSelector);
    formGroupSelector.each(function (index) {
        if (!isValid($(this))) {
            $(this).addClass("has-error");
            //TODO: Add error message below the input element
            isFormValid = false;
        }
        console.log(index + ": " + $(this).find("input").val());
    });
    return isFormValid;
}

function isValid(formGroup) {
    var validationType = formGroup.find("input").attr("ibu-validate");
    var inputData = formGroup.find("input").val();

    if (!inputData) {
        console.log("It's empty!");
        return false;
    }
    return validate(inputData, validationType);
}

function validate(inputData, validationType) {
    if (validationType === "text") {
        return true;
    } else if (validationType === "number") {
        var intRegex = /^\d+$/;
        return intRegex.test(inputData);
    } else if (validationType === "isbn") {
        return validateIsbn(inputData);
    } else {
        return true;
    }
}

function resetValidation(formGroupSelector) {
    formGroupSelector.removeClass("has-error");
}


function validateIsbn(subject) {
    // `regex` checks for ISBN-10 or ISBN-13 format
    var regex = /^(?:ISBN(?:-1[03])?:? )?(?=[0-9X]{10}$|(?=(?:[0-9]+[\- ]){3})[\- 0-9X]{13}$|97[89][0-9]{10}$|(?=(?:[0-9]+[\- ]){4})[\- 0-9]{17}$)(?:97[89][\- ]?)?[0-9]{1,5}[\- ]?[0-9]+[\- ]?[0-9]+[\- ]?[0-9X]$/;
    if (regex.test(subject)) {
        // Remove non ISBN digits, then split into an array
        var chars = subject.replace(/[^0-9X]/g, "").split("");
        // Remove the final ISBN digit from `chars`, and assign it to `last`
        var last = chars.pop();
        var sum = 0;
        var digit = 10;
        var check;

        if (chars.length == 9) {
            // Compute the ISBN-10 check digit
            for (var i = 0; i < chars.length; i++) {
                sum += digit * parseInt(chars[i], 10);
                digit -= 1;
            }
            check = 11 - (sum % 11);
            if (check == 10) {
                check = "X";
            } else if (check == 11) {
                check = "0";
            }
        } else {
            // Compute the ISBN-13 check digit
            for (var i = 0; i < chars.length; i++) {
                sum += (i % 2 * 2 + 1) * parseInt(chars[i], 10);
            }
            check = 10 - (sum % 10);
            if (check == 10) {
                check = "0";
            }
        }

        if (check == last) {
            return true;
        } else {
            console.log("Invalid ISBN check digit");
            return false;
        }
    } else {
        console.log("Invalid ISBN");
        return false;
    }
}