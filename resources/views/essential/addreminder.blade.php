<div class="add-reminder">
    <hr>
    <h4> <span class="fa fa-calendar"></span> Add Reminder </h4>
    <hr>

    <form name="add-reminder-form" method='POST'>

        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="r-title">Title</span>
            </div>
            <input type="text" name="title" id="title" class="form-control" placeholder="Title of Reminder" aria-describedby="r-title" required>

            &nbsp;

            <div class="input-group-prepend ">
                <span class="input-group-text" id="date" required>Date</span>
            </div>
            <input type="date" class="form-control" id="date" name="date" required>

            &nbsp;

            <div class="input-group-prepend">
                <span class="input-group-text" id="time">Time</span>
            </div>
            <input type="time" class="form-control" id="time" name="time" required>
        </div>

        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">Description</span>
            </div>
            <textarea class="form-control" aria-label="Description" id="description" name="description" placeholder="Add description of the reminder" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary mt-2">Add Reminder</button>

    </form>

    <div id="info-msg"></div>

    <p class="text-danger">Indian timezone (UTC + 5:30) will be used for reminder time.</p>


    <!-- use ajax to save reminder -->

    <script>

        const date = new Date();
        var ISToffSet = 330;
        offset = ISToffSet * 60 * 1000;
        var ISTTime = new Date(date.getTime()+offset);
        var today = ISTTime.toISOString().split('T')[0];

        document.getElementsByName("date")[0].setAttribute('min', today);

        $(document).ready(function() {
            $('form[name="add-reminder-form"]').on('submit', function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = form.serialize();
                $.ajax({
                    url: "/reminder",
                    type: "POST",
                    data: formData,
                    success: function(data) {
                        if (data.success) {
                            swal({
                                title: "Reminder added successfully.",
                                text: "You will be reminded 5 minutes before the event.",
                                icon: "success",
                                button: "Great!",
                            });

                            getReminders();

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



</div>