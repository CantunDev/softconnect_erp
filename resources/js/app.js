import './bootstrap';
// import 'laravel-datatables-vite';


import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// public/js/app.js
function initSettings() {
    if (window.localStorage) {
        var alreadyVisited = localStorage.getItem("is_visited");
        if (!alreadyVisited) {
            localStorage.setItem("is_visited", "light-mode-switch");
        } else {
            $(".right-bar input:checkbox").prop('checked', false);
            $("#" + alreadyVisited).prop('checked', true);
            updateThemeSetting(alreadyVisited);
        }
    }

    function updateThemeToggle() {
        let savedTheme = localStorage.getItem("is_visited");

        if (savedTheme === 'dark-mode-switch') {
            $("#theme-toggle").prop("checked", true);
        } else {    
            $("#theme-toggle").prop("checked", false);
        }
    }

    updateThemeToggle();

    $("#theme-toggle").on("change", function () {
        if ($(this).prop("checked")) {
            $("#dark-mode-switch").prop("checked", true).trigger("change");
            localStorage.setItem("is_visited", "dark-mode-switch");
        } else {
            $("#light-mode-switch").prop("checked", true).trigger("change");
            localStorage.setItem("is_visited", "light-mode-switch");
        }
    });

    $("#light-mode-switch, #dark-mode-switch, #rtl-mode-switch, #dark-rtl-mode-switch").on("change", function (e) {
        updateThemeSetting(e.target.id);
    });

    // show password input value
    $("#password-addon").on('click', function () {
        if ($(this).siblings('input').length > 0) {
            $(this).siblings('input').attr('type') == "password" ? $(this).siblings('input').attr('type', 'input') : $(this).siblings('input').attr('type', 'password');
        }
    })
    $("#password-addon2").on('click', function () {
        if ($(this).siblings('input').length > 0) {
            $(this).siblings('input').attr('type') == "password" ? $(this).siblings('input').attr('type', 'input') : $(this).siblings('input').attr('type', 'password');
        }
    })
}

function updateThemeSetting(id) {
    if ($("#light-mode-switch").prop("checked") == true && id === "light-mode-switch") {
        $("html").removeAttr("dir");
        $("#dark-mode-switch").prop("checked", false);
        $("#bootstrap-style").attr('href', '/assets/css/bootstrap.min.css');
        $("#app-style").attr('href', '/assets/css/app.min.css');
        localStorage.setItem("is_visited", "light-mode-switch");
    } else if ($("#dark-mode-switch").prop("checked") == true && id === "dark-mode-switch") {
        $("html").removeAttr("dir");
        $("#light-mode-switch").prop("checked", false);
        $("#bootstrap-style").attr('href', '/assets/css/bootstrap-dark.min.css');
        $("#app-style").attr('href', '/assets/css/app-dark.min.css');
        localStorage.setItem("is_visited", "dark-mode-switch");
    }
}