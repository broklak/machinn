<script>
    function checkAll(ele, className) {
        var checkboxes = document.getElementsByClassName(className);
        if (ele.checked) {
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == 'checkbox') {
                    checkboxes[i].checked = true;
                }
            }
        } else {
            for (var i = 0; i < checkboxes.length; i++) {
                console.log(i)
                if (checkboxes[i].type == 'checkbox') {
                    checkboxes[i].checked = false;
                }
            }
        }
    }

    function grantAll(elem){
        var id = elem.data('id');
        $('#create-'+id).attr('checked', 'checked');
        $('#update-'+id).attr('checked', 'checked');
        $('#read-'+id).attr('checked', 'checked');
        $('#delete-'+id).attr('checked', 'checked');

        $('#grant-'+id).hide();
        $('#revoke-'+id).show();
    }

    function revokeAll(elem){
        var id = elem.data('id');
        $('#create-'+id).removeAttr('checked');
        $('#read-'+id).removeAttr('checked');
        $('#update-'+id).removeAttr('checked');
        $('#delete-'+id).removeAttr('checked');

        $('#revoke-'+id).hide();
        $('#grant-'+id).show();
    }
</script>