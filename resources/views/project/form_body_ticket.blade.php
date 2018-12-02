
<div class="project_form_ticket_tab_container">
  <div class="project_form_ticket_tab_wrapper">
    <ul class="nav nav-pills nav-justified">
      <li class="project_form_ticket_tab active">
        <a data-toggle="pill" href="#menu_ticket" class="project_form_ticket_tab_text">티켓 정보</a>
      </li>
      <li class="project_form_ticket_tab"><a data-toggle="pill" href="#menu_discount" class="project_form_ticket_tab_text">할인 정보</a></li>
      <li class="project_form_ticket_tab"><a data-toggle="pill" href="#menu_md" class="project_form_ticket_tab_text">굿즈 정보</a></li>
    </ul>
  </div>
</div>

  <div class="tab-content">
    <div id="menu_ticket" class="tab-pane fade in active">
      @include('project.form_body_ticket_ticket', ['project' => $project])
    </div>
    <div id="menu_discount" class="tab-pane fade">
      @include('project.form_body_ticket_discount', ['project' => $project])
    </div>
    <div id="menu_md" class="tab-pane fade">
      @include('project.form_body_ticket_goods', ['project' => $project])
    </div>
  </div>
