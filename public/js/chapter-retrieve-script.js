/**
 * Created by bernardsa on 11/17/2018.
 */

$(document).ready(function(){
    var selectedrow;
    var selectedrowactual;
    var table = $('#dtrows').DataTable({
        "columnDefs": [
            { className: "hideCol", "targets": [ 9 ] }
        ]
    });

    //Remove camper from table list
    $('#dtrows tbody').on('click','.row-delete',function(e){
        e.preventDefault();

        var confirmdelete = confirm('Are you sure you want to Delete from list?');
        if(confirmdelete){
            var data = table.row( $(this).parents('tr') ).data();
            var other_details =  data[9];
            //Convert | delimeter separated string to array
            var details_array = other_details.split('|');

            $('#camperid').val(details_array[12]);
            $('#batch_no').val(details_array[13]);

            token = $("input[name='_token']").val(); // get csrf field.

            var formData = {
                _token: token,
                camperid: $('#camperid').val(),
                batch_no: $('#batch_no').val()}
//                alert(JSON.stringify(formData));
//                return;
            $.ajax({
                type: 'post',
                url: "<?php echo url('chaptermemberdelete');?>",
                data: formData,
                dataType: 'json',
                success: function (data) {
                    console.log(JSON.stringify(data));
                },
                error: function (data) {
                    console.log('Error:', JSON.stringify(data));
                }
            });

            table.row( $(this).parents('tr') ).remove().draw();
        }
        else return;
    });

    //Update camper data in table list
    $('#dtrows tbody').on('click','.form-edit',function(e){
        //get selected row data
        selectedrow = table.row( $(this).parents('tr') ).data();
        selectedrowactual="";
        selectedrowactual = $(this).parents('tr');
//                alert(selectedrowactual);

        var other_details =  selectedrow[9];
        //Convert | delimeter separated string to array
        var details_array = other_details.split('|');
        //Set other details in to inputs
        /*0=>marital_status  1=>nationality  2=>local_assembly   3=>area     4=>permanent_address 5=>telephone
         6=>email 7=>officechurch  8=>profession  9=>business_address  11=>agdleader   12=>camper_id 13=>batch_no*/
//                alert(JSON.stringify(details_array));

        $('#surname').val(selectedrow[0]);
        $('#firstname').val(selectedrow[1]);
        $('#datepicker').val(selectedrow[2]);
        $('#localassembly').val(details_array[2]);
        $('#permaddress').val(details_array[4]);
        $('#telephone').val(details_array[5]);
        $('#email').val(details_array[6]);
        $('#businessaddress').val(details_array[9]);
        $('#profession').val(details_array[8]);
        $('#camperid').val(details_array[12]);
        $('#batch_no').val(details_array[13]);

        $('#gender option').filter(function() {return ($(this).text() == selectedrow[3]);}).prop('selected', true);
        $('#campercat option').filter(function() {return ($(this).text() == selectedrow[4]);}).prop('selected', true);
        $('#campfee option').filter(function() {return ($(this).text() == selectedrow[5]);}).prop('selected', true);
        $('#agdlang option').filter(function() {return ($(this).text() == selectedrow[6]);}).prop('selected', true);
        $('#maritalstatus option').filter(function() {return ($(this).text() == details_array[0]);}).prop('selected', true);
        $('#officechurch option').filter(function() {return ($(this).text() == details_array[7]);}).prop('selected', true);
        $('#agdleader option').filter(function() {return ($(this).text() == details_array[11]);}).prop('selected', true);
        $('#agdlang option').filter(function() {return ($(this).text() == selectedrow[7]);}).prop('selected', true);
        $('#myModalLabel').html('Edit: '+selectedrow[1]+' '+selectedrow[0]);

        $("input[name='entrytype']").val(2);
        $('#myModal').modal('show');
    });

    $('#addcamper').click(function () {
        $('#myModalLabel').html('Add New Camper');
        $("input[name='entrytype']").val(1);
        $('#myModal').modal('show');
    })

    //create new camper / update existing camper
    $("#btn-save").click(function (e) {
        formtype = $("input[name='entrytype']").val();
        token = $("input[name='_token']").val(); // get csrf field.
//                alert(token);
        e.preventDefault();
        var formData = {
            _token: token,
            entry_form: formtype,
            camperid: $('#camperid').val(),
            batch_no: $('#batch_no').val(),
            surname: $('#surname').val(),
            firstname: $('#firstname').val(),
            gender_id: $('#gender').val(),
            dob: $('#datepicker').val(),
            maritalstatus_id: $('#maritalstatus').val(),
            localassembly: $('#localassembly').val(),
            telephone: $('#telephone').val(),
            email: $('#email').val(),
            officeaposa: $('#officeaposa').val(),
            officechurch_id: $('#officechurch').val(),
            profession: $('#profession').val(),
            businessaddress: $('#businessaddress').val(),
            campercat_id: $('#campercat').val(),
            camperfee_id: $('#campfee').val(),
            agdlang_id: $('#agdlang').val(),
            agdleader_id: $('#agdleader').val(),

        }
//                console.log(JSON.stringify(formData));
        //used to determine the http verb to use [add=POST], [update=PUT]
//                var state = $('#btn-save').val();
        $.ajax({
            type: 'post',
            url: "<?php echo url('chaptermemberedit');?>",
            data: formData,
            dataType: 'json',
            success: function (data) {
//                        console.log("Returned data from server "+JSON.stringify(data));
//                      //Delete if the form is an update form
                if(formtype == 2)
                    table.row(selectedrowactual).remove().draw();
                var registrant = data['data'];
                var rowNode = table
                    .row.add( [ registrant['firstname'], registrant['surname'], registrant['olddob'],registrant['gender'],registrant['camper'],registrant['Applicable_Camp_Fee'],
                        registrant['Type_of_Special_Accomodation'],registrant['AGD_Language'],
                        '<a href="#" class="btn-warning btn-sm form-edit" style="padding:5px;width:auto;">Edit</a><a href="#" class="btn-danger row-delete" style="padding:3px;width:auto;margin:0" >Delete</a>',
                        ''+registrant['marital_status']+'|'+registrant['nationality']+''
//                                    +'|'.$registrant->local_assembly.'|'.$registrant->area.'|'.$registrant->permanent_address.'|'.$registrant->telephone
//                                    +'|'.$registrant->email.'|'.$registrant->officechurch.'|'.$registrant->profession.'|'.$registrant->business_address
//                                    +'|'.$registrant->business_address.'|'.$registrant->agd_leader.'|'.$registrant->id.'|'.$registrant->batch_no' ' +
                    ])
                    .draw()
                    .node();

                $( rowNode )
                    .css( 'color', 'blue' );

                $('#camper-form')[0].reset();
                $('#myModal').modal('hide')
                if(data['mcode'] == 1){
                    var message="";
                    if(formtype == 2){
                        message= "Member update was succesful!";
                    }
                    else{
                        message= "Member added succesfully!";
                    }
                    swal({
                        title:"Success",
                        text:message,
                        type:"success"
                    });
                }
            },
            error: function (data) {
                console.log('Error:', JSON.stringify(data));
            }
        });
    });

    $(function() {
        $( ".datepicker" ).datepicker({changeMonth: true,changeYear: true,showButtonPanel: true,yearRange: "-40:-2 ",dateFormat: "yy-mm-dd"});
    });

    $("#telephone").keypress(function (event) { return isNumberKey(event) });
    $("#ambassadorphone").keypress(function (event) { return isNumberKey(event) });
    //function to check if value entered is numeric
    function isNumberKey(evt) { var charCode = (evt.which) ? evt.which : event.keyCode; if (charCode > 31 && (charCode < 48 || charCode > 57)) { return false; } return true; }
    function isNumber(evt) { var charCode = (evt.which) ? evt.which : event.keyCode; if (charCode != 45 && (charCode != 46 || $(this).val().indexOf('.') != -1) && (charCode < 48 || charCode > 57)) return false; return true; }
    //        })


    function showFee() {
        // var campfeeid = $('select#campfee').val();
        var campfeeid = document.getElementById('campfee').value;
        if(campfeeid != 43){
            document.getElementById('speAcc').disabled = true;
            document.getElementById('speAcc').value = null;
        }else{
            document.getElementById('speAcc').disabled = false;
        }
    }
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass   : 'iradio_flat-green'
    })
});
