

<div id="cl-wrapper">
    <div class="cl-sidebar">
        <?php $this->load->view('menu_left'); ?>
    </div>
    <div class="container-fluid" id="pcont">
        <div class="cl-mcont">
            <div class="stats_bar">
            <div class="butpro butstyle flat">
              <div class="sub">
                <h2>CLIENTS</h2><span id="total_clientes">170</span>
              </div>
              <div class="stat"><span class="spk1">
                  <canvas style="display: inline-block; width: 74px; height: 16px; vertical-align: top;" width="74" height="16"></canvas></span></div>
            </div>
            <div class="butpro butstyle flat">
              <div class="sub">
                <h2>Sales</h2><span>$951,611</span>
              </div>
              <div class="stat"><span class="up"> 13,5%</span></div>
            </div>
            <div class="butpro butstyle flat">
              <div class="sub">
                <h2>VISITS</h2><span>125</span>
              </div>
              <div class="stat"><span class="down"> 20,7%</span></div>
            </div>
            <div class="butpro butstyle flat">
              <div class="sub">
                <h2>NEW USERS</h2><span>18</span>
              </div>
              <div class="stat"><span class="equal"> 0%</span></div>
            </div>
            <div class="butpro butstyle flat">
              <div class="sub">
                <h2>AVERAGE</h2><span>3%</span>
              </div>
              <div class="stat"><span class="spk2"></span></div>
            </div>
            <div class="butpro butstyle flat">
              <div class="sub">
                <h2>Downloads</h2><span>184</span>
              </div>
              <div class="stat"><span class="spk3"></span></div>
            </div>
          </div>
            <div class="row dash-cols">
            <div class="col-sm-6 col-md-6">
              <ul class="timeline">
                <li><i class="fa fa-comment"></i><span class="date">5 Jan</span>
                  <div class="content">
                    <p><strong>John</strong> has called Shenlong with <strong>You</strong>.</p><small>A minute ago</small>
                  </div>
                </li>
                <li><i class="fa fa-envelope green"></i><span class="date">5 Jan</span>
                  <div class="content"><i class="fa fa-paperclip pull-right"></i>
                    <p><strong>Bob</strong><br>This is a message for you in your birthday.</p><a href="assets/img/gallery/img4.jpg" class="image-zoom"><img src="assets/img/gallery/img4.jpg" style="height:64px;" class="img-thumbnail"></a><a href="assets/img/gallery/img6.jpg" class="image-zoom"><img src="assets/img/gallery/img6.jpg" style="height:64px;" class="img-thumbnail"></a>
                  </div>
                </li>
                <li><i class="fa fa-file red"></i><span class="date">5 Jan</span>
                  <div class="content">
                    <p><strong>Michael</strong> has wrote on your wall:</p>
                    <blockquote>
                      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p><small>Some historic guy</small>
                    </blockquote>
                  </div>
                </li>
                <li><i class="fa fa-globe purple"></i><span class="date">5 Jan</span>
                  <div class="content">
                    <p><strong>María</strong> This is a message for you in your birthday.</p>
                  </div>
                </li>
              </ul>
              <div class="block-flat">
                <div class="header">
                  <h3>Latest Tickets</h3>
                </div>
                <div class="content">
                  <div class="list-group tickets">
                    <li href="#" class="list-group-item"><span class="label label-primary pull-right">Normal</span><img src="assets/img/avatar_50.jpg" class="avatar">
                      <h4 class="name">Jeff Hanneman</h4>
                      <p>My vMaps plugin doesn't work</p><span class="date">17 Feb</span>
                    </li>
                    <li href="#" class="list-group-item"><span class="label label-danger pull-right">Urgent</span><img src="assets/img/avatar4_50.jpg" class="avatar">
                      <h4 class="name">Jhon Doe</h4>
                      <p>My vMaps plugin doesn't work</p><span class="date">15 Feb</span>
                    </li>
                    <li href="#" class="list-group-item"><span class="label label-warning pull-right">Medium</span><img src="assets/img/avatar1_50.jpg" class="avatar">
                      <h4 class="name">Victor Jara</h4>
                      <p>My vMaps plugin doesn't work</p><span class="date">15 Feb</span>
                    </li>
                  </div>
                  <div class="text-center">
                    <button data-modal="reply-ticket" class="btn btn-success btn-flat btn-rad md-trigger">Reply Last</button>
                  </div>
                  <!-- Nifty Modal-->
                  <div id="reply-ticket" class="md-modal colored-header custom-width md-effect-9">
                    <div class="md-content">
                      <div class="modal-header">
                        <h3>Reply Ticket</h3>
                        <button type="button" data-dismiss="modal" aria-hidden="true" class="close md-close">×</button>
                      </div>
                      <div class="modal-body form">
                        <div class="list-group tickets">
                          <li href="#" class="list-group-item"><span class="label label-primary pull-right">Normal</span><img src="assets/img/avatar_50.jpg" class="avatar">
                            <h4 class="name">Jeff Hanneman</h4>
                            <p>My vMaps plugin doesn't work</p><span class="date">17 Feb</span>
                          </li>
                        </div>
                        <div class="form-group flat-editor">
                          <div id="summernote"></div>
                        </div>
                        <p class="spacer2">
                          <input type="checkbox" name="c[]" checked="">  Notify me if this ticket receives any comment.
                        </p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-default btn-flat md-close">Cancel</button>
                        <button type="button" data-dismiss="modal" class="btn btn-primary btn-flat md-close">Reply</button>
                      </div>
                    </div>
                  </div>
                  <div class="md-overlay"></div>
                </div>
              </div>
              <div class="block-flat">
                <div class="content no-padding"><span class="pull-right">February 15 - 30</span>
                  <h4 class="title">Tickets Summary</h4>
                  <div class="list-group tickets">
                    <li href="#" class="list-group-item">Unread <span class="badge badge-primary">20</span></li>
                    <li href="#" class="list-group-item">Open Tickets <span class="badge badge-success">35</span></li>
                    <li href="#" class="list-group-item">Closed Tickets <span class="badge">45</span></li>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-md-6">
              <div class="block-flat pie-widget">
                <div class="content no-padding">
                  <h4 class="no-margin">Top 10 Products</h4>
                  <div class="row">
                    <div class="col-sm-4">
                      <div id="ticket-chart" style="height:160px;"></div>
                    </div>
                    <div class="col-sm-8">
                      <table class="no-borders no-strip padding-sm">
                        <tbody class="no-border-x no-border-y">
                          <tr>
                            <td style="width:15px;">
                              <div data-color="#649BF4" class="legend"></div>
                            </td>
                            <td>Responsive</td>
                            <td class="text-right"><b>$3.500</b></td>
                          </tr>
                          <tr>
                            <td>
                              <div data-color="#19B698" class="legend"></div>
                            </td>
                            <td>Corporate Site</td>
                            <td class="text-right"><b>$3.500</b></td>
                          </tr>
                          <tr>
                            <td>
                              <div data-color="#BD3B47" class="legend"></div>
                            </td>
                            <td>Creative Portfolio</td>
                            <td class="text-right"><b>$3.500</b></td>
                          </tr>
                          <tr>
                            <td>
                              <div data-color="#DD4444" class="legend"></div>
                            </td>
                            <td>Wordpress Theme</td>
                            <td class="text-right"><b>$3.500</b></td>
                          </tr>
                          <tr>
                            <td>
                              <div data-color="#FD9C35" class="legend"></div>
                            </td>
                            <td>Photography Template</td>
                            <td class="text-right"><b>$3.500</b></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="row stats">
                    <div class="col-sm-6">
                      <div class="spk4 pull-right"></div>
                      <p>New Visitors</p>
                      <h5>146</h5>
                    </div>
                    <div class="col-sm-6">
                      <div class="spk5 pull-right"></div>
                      <p>Old Visitors</p>
                      <h5>146</h5>
                    </div>
                  </div>
                </div>
              </div>
              <div class="block-flat">
                <div class="header">
                  <h3>Services</h3>
                </div>
                <div class="content">
                  <table class="no-border">
                    <thead class="no-border">
                      <tr>
                        <th style="width:80%;">Option</th>
                        <th class="text-right">Active</th>
                      </tr>
                    </thead>
                    <tbody class="no-border-y">
                      <tr>
                        <td><strong>Cloud Services</strong><br> This option make active the cloud services</td>
                        <td class="text-right">
                          <input checked="" data-size="small" name="op1" type="checkbox" class="switch">
                        </td>
                      </tr>
                      <tr>
                        <td><strong>SMS Notifications</strong><br> This option actives the notification system</td>
                        <td class="text-right">
                          <input checked="" data-size="small" name="op1" type="checkbox" class="switch">
                        </td>
                      </tr>
                      <tr>
                        <td><strong>Backup</strong><br> This option actives automatic daily backups</td>
                        <td class="text-right">
                          <input checked="" data-size="small" name="op1" type="checkbox" class="switch">
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="block-flat">
                <div class="header">
                  <h3>Visitors</h3>
                </div>
                <div id="world-map" style="height: 300px;" class="content"></div>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>



