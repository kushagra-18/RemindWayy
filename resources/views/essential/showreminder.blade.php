<div class="show-reminder">
    <hr>
    <h4> <span class="fa fa-calendar"></span> Saved Reminders </h4>
    <hr>

    <button type="button" class="btn btn-primary" id = 'not-all' onclick="getReminders(false)">Show All Reminders</button>
    <button type="button" class="btn btn-primary" id = 'all' onclick="getReminders(true)">Show Upcoming Reminders</button>
    


    <!-- show all reminders in a table -->

    <div class = "reminder-data"></div>


</div>

<script>

 
    getReminders(false);


    function deleteReminder(id) {

        $.ajax({
            url: '/reminder',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                _method: 'DELETE'
            },
            success: function(data) {
                swal({
                    title: "Deleted!",
                    text: "Reminder has been deleted.",
                    icon: "success",
                    button: "OK",
                });
                getReminders();
            }
        });
    }

    function getReminders(flag){

        console.log(flag);

        var URL = "";

        if(flag){
            URL = "/reminder/upcoming";
            // change text of all to Showing Upcoming Reminders
            document.getElementById('all').innerHTML = "Showing All Upcoming Reminders";
            document.getElementById('not-all').innerHTML = "Show All Reminders";
        }
        else{
            URL = "/reminder";
            document.getElementById('not-all').innerHTML = "Showing All Reminders";
            document.getElementById('all').innerHTML = "Show Upcoming Reminders";
        }



        $.ajax({
            url: URL,
            type: 'GET',
            success: function(data) {
       
                var html = '';
                html += '<table class="table table-striped">';
                html += '<thead>';
                html += '<tr>';
                html += '<th>Title</th>';
                html += '<th>Date</th>';
                html += '<th>Time</th>';
                html += '<th>Description</th>';
                html += '<th>Action</th>';
                html += '</tr>';
                html += '</thead>';
                html += '<tbody>';
                for (var i = 0; i < data.length; i++) {
                    html += '<tr>';
                    html += '<td>' + data[i].title + '</td>';
                    html += '<td>' + data[i].date + '</td>';
                    html += '<td>' + data[i].time + '</td>';
                    html += '<td>' + data[i].description + '</td>';
                    html += '<td>';
                    html += '<a class="btn btn-danger btn-sm" onclick=deleteReminder(' + data[i].id + ')>Delete</a>';
                    html += '</td>';
                    html += '</tr>';
                }

                html += '</tbody>';
                html += '</table>';
                $('.reminder-data').html(html);
            }
        });
    }

    </script>