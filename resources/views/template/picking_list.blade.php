@if($project->isPickedComplete())
<div class="table_pick_container">
  <div class="table_pick_wrapper">
    <h4>당첨자 명단</h4>
    <p>축하드립니다! 아래는 이번 이벤트에 당첨되신 분들의 명단입니다.</p>
    <table class="table table_pick">
        <thead>
        <tr>
            <td>이름</td>
            <td>전화번호 뒷자리</td>
        </tr>
        </thead>
        <tbody>
        <?php
        $ordersOnlyPick = $project->getOrdersOnlyPick()->get();
        ?>
        @foreach ($ordersOnlyPick as $order)
        <?php
          $name = $order->name;
          $nameLen = mb_strlen($order->name, 'UTF-8');

          if($nameLen == 1)
          {
            $name = '*';
          }
          if($nameLen == 2)
          {
             $name = mb_substr($order->name,0,1, 'utf-8').'*';
          }
          else if($nameLen > 2)
          {
            $name = mb_substr($order->name,0,1, 'utf-8').str_repeat('*',$nameLen-2).mb_substr($order->name,-1,1, 'utf-8');
          }


          $contactLen = strlen($order->contact);
          $contact = $order->contact;
          if($contactLen >= 4)
          {
            $contact = mb_strimwidth($order->contact, $contactLen-4, 4, '', 'utf-8');
          }

        ?>
            <tr>
                <td>
                  {{ $name }}
                </td>
                <td>
                  {{ $contact }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
  </div>
</div>
@endif
