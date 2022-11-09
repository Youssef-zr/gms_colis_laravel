$(() => {
    // hide dashboard loading page
    setTimeout(() => {
        $(".loading-dashboard").fadeOut(1000);
    }, 500);

    $(".show-password").click(function () {
        let inptPassword = $(this).siblings("input");

        console.log(inptPassword);
        if (inptPassword.prop("type") == "password") {
            inptPassword.prop("type", "text");
        } else {
            inptPassword.prop("type", "password");
        }

        let iconEye = $(this).find("i");
        iconEye.toggleClass("fa-eye fa-eye-slash");

        if (iconEye.hasClass("fa-eye")) {
            iconEye.prop("title", "show password");
        } else {
            iconEye.prop("title", "hide password");
        }
    });

    $("#show-profile").on("click", function (e) {
        $(this).siblings(".dropdown-menu").slideToggle();
    });

    // export table pdf
    function exportTableToExcel(tableID, filename = "") {
        var downloadLink;
        var dataType = "application/vnd.ms-excel";
        var tableSelect = document.getElementById(tableID);
        var tableHTML = tableSelect.outerHTML.replace(/ /g, "%20");

        // Specify file name
        filename = filename ? filename + ".xls" : "excel_data.xls";

        // Create download link element
        downloadLink = document.createElement("a");

        document.body.appendChild(downloadLink);

        if (navigator.msSaveOrOpenBlob) {
            var blob = new Blob(["\ufeff", tableHTML], {
                type: dataType,
            });
            navigator.msSaveOrOpenBlob(blob, filename);
        } else {
            // Create a link to the file
            downloadLink.href = "data:" + dataType + ", " + tableHTML;

            // Setting the file name
            downloadLink.download = filename;

            //triggering the function
            downloadLink.click();
        }
    }

    $("#export-pdf").on("click", function (e) {
        e.preventDefault();
        exportTableToExcel("table");
    });
});
