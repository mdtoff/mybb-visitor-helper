<table class="tborder" border="0" cellspacing="{$theme['borderwidth']}" cellpadding="{$theme['tablespace']}">
    <tbody>
        <tr>
            <td class="thead" colspan="3" align="center">
                <strong>{$lang->visitor_helper_title}</strong>
            </td>
        </tr>
        <tr>
            <td class="tcat" colspan="3" align="center">{$lang->visitor_helper_sub_title}</td>
        </tr>
        <tr>
            <td class="trow1" align="center" width="45%">
                <div style="font-size: 20px;">{$lang->visitor_helper_register}</div>
                <div>{$lang->visitor_helper_register_text}</div>
                <div style="margin-top: 5px;">
                    <a class="button" href="member.php?action=register">{$lang->visitor_helper_register_button}</a>
                </div>
            </td>
            <td class="trow2" align="center" width="10%">{$lang->visitor_helper_or}</td>
            <td class="trow1" align="center" width="45%">
                <div style="font-size: 20px;">{$lang->visitor_helper_login}</div>
                <div>{$lang->visitor_helper_login_text}</div>
                <div style="margin-top: 5px;">
                    <a class="button" href="member.php?action=login" onclick="$('#quick_login').modal({ fadeDuration: 250, keepelement: true, zIndex: (typeof modal_zindex !== 'undefined' ? modal_zindex : 9999) }); return false;">{$lang->visitor_helper_login_button}</a>
                </div>
            </td>
        </tr>
    </tbody>
</table>
