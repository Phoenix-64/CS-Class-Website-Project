window.onload = function () {
    checkConsent()

}
// checkConsent();
function checkConsent()
{

    let cookie_consent = getCookie("user_cookie_consent");
    if (cookie_consent != "") {
        document.getElementById("cookieNotice").style.display = "none";

        if (getCookie("darkmode_selection") == "0") {
            document.getElementById("darkmode").checked = false;
            document.getElementById("pagestyle").setAttribute("href", "styles_bright.css");
        }
    } else {
        document.getElementById("cookieNotice").style.display = "block";
    }

}

// Create cookie
function setCookie(cname, cvalue, exdays)
{
    const d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    let expires     = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";

}

// Delete cookie
function deleteCookie(cname)
{
    const d = new Date();
    d.setTime(d.getTime() + (24 * 60 * 60 * 1000));
    let expires     = "expires=" + d.toUTCString();
    document.cookie = cname + "=;" + expires + ";path=/";

}

// Read cookie
function getCookie(cname)
{
    let name          = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca            = decodedCookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }

        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }

    return "";

}

// Set cookie consent
function acceptCookieConsent()
{
    deleteCookie('user_cookie_consent');
    setCookie('user_cookie_consent', 1, 30);
    document.getElementById("cookieNotice").style.display = "none";
    console.log("done");

}
function rejectCookieConsent()
{
    document.getElementById("cookieNotice").style.display = "none";
    console.log("done");

}

// Set darkmode cookie
function setDarkmodeCookie()
{
    console.log("Set darkmode prefrence")
    if (getCookie("user_cookie_consent") != "") {
        deleteCookie('darkmode_selection');

        if (document.getElementById("darkmode").checked) {
            setCookie('darkmode_selection', 1, 30);
            document.getElementById("pagestyle").setAttribute("href", "styles_dark.css");
        } else {
            setCookie('darkmode_selection', 0, 30);
            document.getElementById("pagestyle").setAttribute("href", "styles_bright.css");
        }
    } else {
        if (document.getElementById("darkmode").checked) {
            document.getElementById("pagestyle").setAttribute("href", "styles_dark.css");
        } else {
            document.getElementById("pagestyle").setAttribute("href", "styles_bright.css");
        }
    }//end if

}
