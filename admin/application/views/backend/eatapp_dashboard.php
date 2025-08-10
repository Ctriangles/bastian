<div class="row">
    <div class="col-xl-12">
        <div class="row">
            <!-- Total Reservations -->
            <div class="col-xl-3 col-md-6">
                <div class="card mini-stat bg-primary">
                    <div class="card-body">
                        <div class="mb-4">
                            <div class="float-start mini-stat-img me-4">
                                <img src="<?=site_url('assets/images/services-icon/01.png')?>" alt="">
                            </div>
                            <h5 class="font-size-16 text-uppercase mt-0 text-white-50">Total Reservations</h5>
                            <h4 class="fw-medium font-size-24"><?=number_format($stats['total'])?></h4>
                        </div>
                        <div class="pt-2">
                            <div class="float-end">
                                <a href="<?=site_url('backend/eatapp_reservations/')?>" class="text-white-50"><i class="mdi mdi-arrow-right h5"></i></a>
                            </div>
                            <p class="text-white-50 mb-0">All time reservations</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Confirmed Reservations -->
            <div class="col-xl-3 col-md-6">
                <div class="card mini-stat bg-success">
                    <div class="card-body">
                        <div class="mb-4">
                            <div class="float-start mini-stat-img me-4">
                                <img src="<?=site_url('assets/images/services-icon/02.png')?>" alt="">
                            </div>
                            <h5 class="font-size-16 text-uppercase mt-0 text-white-50">Confirmed</h5>
                            <h4 class="fw-medium font-size-24"><?=number_format($stats['confirmed'])?></h4>
                        </div>
                        <div class="pt-2">
                            <div class="float-end">
                                <a href="<?=site_url('backend/eatapp_reservations/?status=confirmed')?>" class="text-white-50"><i class="mdi mdi-arrow-right h5"></i></a>
                            </div>
                            <p class="text-white-50 mb-0">Successfully confirmed</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Pending Reservations -->
            <div class="col-xl-3 col-md-6">
                <div class="card mini-stat bg-warning">
                    <div class="card-body">
                        <div class="mb-4">
                            <div class="float-start mini-stat-img me-4">
                                <img src="<?=site_url('assets/images/services-icon/03.png')?>" alt="">
                            </div>
                            <h5 class="font-size-16 text-uppercase mt-0 text-white-50">Pending</h5>
                            <h4 class="fw-medium font-size-24"><?=number_format($stats['pending'])?></h4>
                        </div>
                        <div class="pt-2">
                            <div class="float-end">
                                <a href="<?=site_url('backend/eatapp_reservations/?status=pending')?>" class="text-white-50"><i class="mdi mdi-arrow-right h5"></i></a>
                            </div>
                            <p class="text-white-50 mb-0">Awaiting confirmation</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Failed Reservations -->
            <div class="col-xl-3 col-md-6">
                <div class="card mini-stat bg-danger">
                    <div class="card-body">
                        <div class="mb-4">
                            <div class="float-start mini-stat-img me-4">
                                <img src="<?=site_url('assets/images/services-icon/04.png')?>" alt="">
                            </div>
                            <h5 class="font-size-16 text-uppercase mt-0 text-white-50">Failed</h5>
                            <h4 class="fw-medium font-size-24"><?=number_format($stats['failed'])?></h4>
                        </div>
                        <div class="pt-2">
                            <div class="float-end">
                                <a href="<?=site_url('backend/eatapp_reservations/?status=failed')?>" class="text-white-50"><i class="mdi mdi-arrow-right h5"></i></a>
                            </div>
                            <p class="text-white-50 mb-0">Failed to confirm</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Activity -->
        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Recent Reservations</h4>
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th>Guest</th>
                                        <th>Restaurant</th>
                                        <th>Date & Time</th>
                                        <th>Covers</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($recent_reservations)): ?>
                                        <?php foreach($recent_reservations as $reservation): ?>
                                        <tr>
                                            <td>
                                                <div>
                                                    <h5 class="font-size-14 mb-1"><?=$reservation->first_name?> <?=$reservation->last_name?></h5>
                                                    <p class="text-muted mb-0"><?=$reservation->email?></p>
                                                </div>
                                            </td>
                                            <td><?=$reservation->restaurant_id?></td>
                                            <td><?=date('M d, Y H:i', strtotime($reservation->start_time))?></td>
                                            <td><?=$reservation->covers?></td>
                                            <td>
                                                <?php if($reservation->status == 'confirmed'): ?>
                                                    <span class="badge bg-success">Confirmed</span>
                                                <?php elseif($reservation->status == 'pending'): ?>
                                                    <span class="badge bg-warning">Pending</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger">Failed</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?=date('M d, Y H:i', strtotime($reservation->created_at))?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">No recent reservations</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Quick Stats</h4>
                        <div class="row">
                            <div class="col-6">
                                <div class="text-center">
                                    <h5 class="font-size-16">Today</h5>
                                    <h4 class="fw-medium"><?=number_format($stats['today'])?></h4>
                                    <p class="text-muted mb-0">Reservations</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center">
                                    <h5 class="font-size-16">This Week</h5>
                                    <h4 class="fw-medium"><?=number_format($stats['this_week'])?></h4>
                                    <p class="text-muted mb-0">Reservations</p>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <div class="text-center">
                                    <h5 class="font-size-16">This Month</h5>
                                    <h4 class="fw-medium"><?=number_format($stats['this_month'])?></h4>
                                    <p class="text-muted mb-0">Reservations</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center">
                                    <h5 class="font-size-16">Restaurants</h5>
                                    <h4 class="fw-medium"><?=count($restaurants)?></h4>
                                    <p class="text-muted mb-0">Active</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Quick Actions</h4>
                        <div class="d-grid gap-2">
                            <a href="<?=site_url('backend/eatapp_reservations/')?>" class="btn btn-primary">
                                <i class="uil-list-ul me-2"></i>View All Reservations
                            </a>
                            <a href="<?=site_url('backend/eatapp_cache/')?>" class="btn btn-info">
                                <i class="uil-database me-2"></i>Manage Cache
                            </a>
                            <a href="<?=site_url('api/eatapp/restaurants')?>" class="btn btn-success" target="_blank">
                                <i class="uil-restaurant me-2"></i>Test API
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 