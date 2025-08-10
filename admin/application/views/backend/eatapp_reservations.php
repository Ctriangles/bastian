<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <!-- Search and Filter -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <form method="GET" action="<?=site_url('backend/eatapp_reservations/')?>" class="d-flex">
                            <input type="text" name="search" class="form-control me-2" placeholder="Search by name, email, phone..." value="<?=$this->input->get('search')?>">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </form>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="btn-group" role="group">
                            <a href="<?=site_url('backend/eatapp_reservations/')?>" class="btn btn-outline-primary <?=!$this->input->get('status') ? 'active' : ''?>">All</a>
                            <a href="<?=site_url('backend/eatapp_reservations/?status=confirmed')?>" class="btn btn-outline-success <?=$this->input->get('status') == 'confirmed' ? 'active' : ''?>">Confirmed</a>
                            <a href="<?=site_url('backend/eatapp_reservations/?status=pending')?>" class="btn btn-outline-warning <?=$this->input->get('status') == 'pending' ? 'active' : ''?>">Pending</a>
                            <a href="<?=site_url('backend/eatapp_reservations/?status=failed')?>" class="btn btn-outline-danger <?=$this->input->get('status') == 'failed' ? 'active' : ''?>">Failed</a>
                        </div>
                    </div>
                </div>

                <!-- Statistics Row -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body text-center">
                                <h4><?=number_format($stats['total'])?></h4>
                                <p class="mb-0">Total Reservations</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body text-center">
                                <h4><?=number_format($stats['confirmed'])?></h4>
                                <p class="mb-0">Confirmed</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body text-center">
                                <h4><?=number_format($stats['pending'])?></h4>
                                <p class="mb-0">Pending</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-danger text-white">
                            <div class="card-body text-center">
                                <h4><?=number_format($stats['failed'])?></h4>
                                <p class="mb-0">Failed</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reservations Table -->
                <div class="table-responsive">
                    <table class="table table-centered table-nowrap mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Guest Details</th>
                                <th>Restaurant</th>
                                <th>Reservation Details</th>
                                <th>Status</th>
                                <th>EatApp Key</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($AllDatas)): ?>
                                <?php foreach($AllDatas as $reservation): ?>
                                <tr>
                                    <td>
                                        <span class="badge bg-light text-dark">#<?=$reservation->id?></span>
                                    </td>
                                    <td>
                                        <div>
                                            <h6 class="mb-1"><?=$reservation->first_name?> <?=$reservation->last_name?></h6>
                                            <p class="text-muted mb-0"><?=$reservation->email?></p>
                                            <small class="text-muted"><?=$reservation->phone?></small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info"><?=$reservation->restaurant_id?></span>
                                    </td>
                                    <td>
                                        <div>
                                            <strong><?=date('M d, Y', strtotime($reservation->start_time))?></strong><br>
                                            <small class="text-muted"><?=date('H:i', strtotime($reservation->start_time))?></small><br>
                                            <span class="badge bg-secondary"><?=$reservation->covers?> covers</span>
                                            <?php if($reservation->notes): ?>
                                                <br><small class="text-muted"><?=substr($reservation->notes, 0, 50)?><?=strlen($reservation->notes) > 50 ? '...' : ''?></small>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if($reservation->status == 'confirmed'): ?>
                                            <span class="badge bg-success">Confirmed</span>
                                        <?php elseif($reservation->status == 'pending'): ?>
                                            <span class="badge bg-warning">Pending</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Failed</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($reservation->eatapp_reservation_key): ?>
                                            <span class="badge bg-primary"><?=$reservation->eatapp_reservation_key?></span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <small><?=date('M d, Y H:i', strtotime($reservation->created_at))?></small>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#" onclick="viewReservation(<?=$reservation->id?>)">
                                                    <i class="uil-eye me-2"></i>View Details
                                                </a></li>
                                                <?php if($reservation->status == 'pending'): ?>
                                                <li><a class="dropdown-item" href="#" onclick="updateStatus(<?=$reservation->id?>, 'confirmed')">
                                                    <i class="uil-check me-2"></i>Mark Confirmed
                                                </a></li>
                                                <?php endif; ?>
                                                <?php if($reservation->status != 'failed'): ?>
                                                <li><a class="dropdown-item" href="#" onclick="updateStatus(<?=$reservation->id?>, 'failed')">
                                                    <i class="uil-times me-2"></i>Mark Failed
                                                </a></li>
                                                <?php endif; ?>
                                                <li><hr class="dropdown-divider"></li>
                                                <li><a class="dropdown-item text-danger" href="#" onclick="deleteReservation(<?=$reservation->id?>)">
                                                    <i class="uil-trash me-2"></i>Delete
                                                </a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <div class="py-4">
                                            <i class="uil-inbox font-size-24 text-muted"></i>
                                            <p class="text-muted mt-2">No reservations found</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reservation Details Modal -->
<div class="modal fade" id="reservationModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reservation Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="reservationModalBody">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<!-- Status Update Form -->
<form id="statusForm" method="POST" action="<?=site_url('backend/update_reservation_status')?>" style="display: none;">
    <input type="hidden" name="id" id="statusId">
    <input type="hidden" name="status" id="statusValue">
</form>

<script>
function viewReservation(id) {
    // Load reservation details via AJAX
    fetch('<?=site_url('api/eatapp/get_reservations')?>')
        .then(response => response.json())
        .then(data => {
            const reservation = data.data.find(r => r.id == id);
            if(reservation) {
                let modalContent = `
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Guest Information</h6>
                            <p><strong>Name:</strong> ${reservation.first_name} ${reservation.last_name}</p>
                            <p><strong>Email:</strong> ${reservation.email}</p>
                            <p><strong>Phone:</strong> ${reservation.phone}</p>
                            ${reservation.notes ? `<p><strong>Notes:</strong> ${reservation.notes}</p>` : ''}
                        </div>
                        <div class="col-md-6">
                            <h6>Reservation Details</h6>
                            <p><strong>Restaurant:</strong> ${reservation.restaurant_id}</p>
                            <p><strong>Date & Time:</strong> ${new Date(reservation.start_time).toLocaleString()}</p>
                            <p><strong>Covers:</strong> ${reservation.covers}</p>
                            <p><strong>Status:</strong> <span class="badge bg-${reservation.status === 'confirmed' ? 'success' : reservation.status === 'pending' ? 'warning' : 'danger'}">${reservation.status}</span></p>
                            ${reservation.eatapp_reservation_key ? `<p><strong>EatApp Key:</strong> ${reservation.eatapp_reservation_key}</p>` : ''}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <h6>Timestamps</h6>
                            <p><strong>Created:</strong> ${new Date(reservation.created_at).toLocaleString()}</p>
                            <p><strong>Updated:</strong> ${new Date(reservation.updated_at).toLocaleString()}</p>
                        </div>
                    </div>
                `;
                document.getElementById('reservationModalBody').innerHTML = modalContent;
                new bootstrap.Modal(document.getElementById('reservationModal')).show();
            }
        });
}

function updateStatus(id, status) {
    if(confirm('Are you sure you want to update this reservation status?')) {
        document.getElementById('statusId').value = id;
        document.getElementById('statusValue').value = status;
        document.getElementById('statusForm').submit();
    }
}

function deleteReservation(id) {
    if(confirm('Are you sure you want to delete this reservation? This action cannot be undone.')) {
        // Implement delete functionality
        alert('Delete functionality to be implemented');
    }
}
</script> 