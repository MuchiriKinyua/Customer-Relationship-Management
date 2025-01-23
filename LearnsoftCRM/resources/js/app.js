import './bootstrap';
import 'admin-lte';

import $ from 'jquery';
import 'jquery-ui/ui/widgets/datepicker';

$(document).ready(function() {
    $('#lead_date').datepicker({
        dateFormat: 'mm-dd-yy'
    });
});
