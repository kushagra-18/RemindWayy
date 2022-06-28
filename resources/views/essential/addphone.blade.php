<div class="alert alert-warning alert-dismissible fade show number-warning" role="alert">
    <strong>Hey,</strong> If you wish to recieve reminders on SMS, please add your phone number <a class="phone-add-btn" onclick="addPhone()">here</a>.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<div class = 'add-phone' style="display: none;">
    <form name = 'add-phone-form' method = 'POST'>

    <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="text" class="form-control" id="phone" name = 'phone' placeholder="Enter Phone Number">
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script>

   function addPhone(){

        $('.add-phone').toggle();
   }

   $(document).ready(function() {
            $('form[name="add-phone-form"]').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = form.serialize();
                $.ajax({
                    url: "/add-phone",
                    type: "POST",
                    data: formData,
                    success: function(data) {
                        if (data.success) {
                            swal({
                                title: "Success",
                                text: "Phone number added successfully.",
                                icon: "success",
                                button: "Great!",
                            });

                            document.getElementsByClassName('number-warning')[0].style.display = 'none';
                            $('.add-phone').toggle();
                        
                        } else {
                            swal({
                                title: "Error",
                                text: data.error,
                                icon: "error",
                                button: "Ok!",
                            });
                        }
                    }
                });
            });
        });


</script>