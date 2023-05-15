// the clean way of implementing darkmode would be using the prefers-color-scheme property.
// but to show that I am able to use javascript and save cookies I decided to implement it on my own
function cookie_notice()
{
    document.write("<div id=\"cookieNotice\" class=\"light display-right\" style=\"display: none;\">");
    document.write("        <div id=\"closeIcon\" style=\"display: none;\">");
    document.write("        <\/div>");
    document.write("        <div class=\"title-wrap\">");
    document.write("            <h4>Cookie Consent<\/h4>");
    document.write("        <\/div>");
    document.write("        <div class=\"content-wrap\">");
    document.write("            <div class=\"msg-wrap\">");
    document.write("                <p>Um deine Darkmode einstellungen zu speichern brauche ich cookies, du kannst sie jedoch auch gerne ablehnen dann musst do aber deine Darkmode einstellungen jedesmal neu setzten<\/p>");
    document.write("                <div class=\"btn-wrap\">");
    document.write("                    <button class=\"btn-primary\" onclick=\"acceptCookieConsent();\">Accept<\/button>");
    document.write("                    <button class=\"btn-primary\" onclick=\"rejectCookieConsent();\">Reject<\/button>");
    document.write("                <\/div>");
    document.write("            <\/div>");
    document.write("        <\/div>");
    document.write("    <\/div>");

}
