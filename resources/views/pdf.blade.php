

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <table class="table table-bordered">
      <tbody>
        <tr>
          <td rowspan="3" colspan="2">
              <img src="data:image/png;base64, {!! $qrcode !!}">
          </td>
          <td rowspan="3" colspan="2" class="title">
              {{$ticket->showing->movie->title}}
          </td>
          <td>
              Room: {{$ticket->showing->room->num_room}}
          </td>
          <td>
              Seat: {{$ticket->num_seat }}
          </td>
        </tr>
        <tr>
            <td>
                {{$ticket->showing->room->roomType->type}}
            </td>
            <td>
                {{$ticket->showing->language->language}}
            </td>
        </tr>
        <tr>
            <td class="num-seat" colspan="2">
                {{$ticket->showing->begin}}
            </td>
        </tr>
      </tbody>
    </table>
  </body>
</html>


<style>
    .table *{
        color: #22577A;
        font-weight: bold;
        vertical-align: middle;
        background-color: #cfe4f2;
    }
    table, th, td {
        border-collapse: collapse;
    }
    td{
        padding: 5px;
        padding-right: 15px;
        vertical-align: middle;
        text-align: center;
    }
    td.title{
        max-width: 150px;
        text-align: center;
    }
</style>
