<div class="row">
    <div class="col-12">
        <!-- Cache Statistics -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body text-center">
                        <h4><?=count($availability_cache)?></h4>
                        <p class="mb-0">Active Cache Entries</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body text-center">
                        <h4><?=count($expired_cache)?></h4>
                        <p class="mb-0">Expired Cache Entries</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h4><?=count($restaurant_cache)?></h4>
                        <p class="mb-0">Restaurant Cache</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <a href="<?=site_url('backend/clear_expired_cache')?>" class="btn btn-light btn-sm">
                            <i class="uil-trash me-2"></i>Clear Expired
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Availability Cache -->
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Availability Cache</h4>
                <div class="table-responsive">
                    <table class="table table-centered table-nowrap mb-0">
                        <thead>
                            <tr>
                                <th>Restaurant ID</th>
                                <th>Date</th>
                                <th>Covers</th>
                                <th>Cached At</th>
                                <th>Expires At</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($availability_cache)): ?>
                                <?php foreach($availability_cache as $cache): ?>
                                <tr>
                                    <td>
                                        <span class="badge bg-info"><?=$cache->restaurant_id?></span>
                                    </td>
                                    <td><?=date('M d, Y', strtotime($cache->date))?></td>
                                    <td><?=$cache->covers?> covers</td>
                                    <td><?=date('M d, Y H:i', strtotime($cache->cached_at))?></td>
                                    <td><?=date('M d, Y H:i', strtotime($cache->expires_at))?></td>
                                    <td>
                                        <span class="badge bg-success">Active</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-info" onclick="viewCacheData(<?=$cache->id?>, 'availability')">
                                            <i class="uil-eye"></i> View
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">No active availability cache entries</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Expired Cache -->
        <?php if(!empty($expired_cache)): ?>
        <div class="card mt-4">
            <div class="card-body">
                <h4 class="card-title mb-4">Expired Cache Entries</h4>
                <div class="table-responsive">
                    <table class="table table-centered table-nowrap mb-0">
                        <thead>
                            <tr>
                                <th>Restaurant ID</th>
                                <th>Date</th>
                                <th>Covers</th>
                                <th>Cached At</th>
                                <th>Expired At</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($expired_cache as $cache): ?>
                            <tr>
                                <td>
                                    <span class="badge bg-info"><?=$cache->restaurant_id?></span>
                                </td>
                                <td><?=date('M d, Y', strtotime($cache->date))?></td>
                                <td><?=$cache->covers?> covers</td>
                                <td><?=date('M d, Y H:i', strtotime($cache->cached_at))?></td>
                                <td><?=date('M d, Y H:i', strtotime($cache->expires_at))?></td>
                                <td>
                                    <span class="badge bg-danger">Expired</span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Restaurant Cache -->
        <div class="card mt-4">
            <div class="card-body">
                <h4 class="card-title mb-4">Restaurant Cache</h4>
                <div class="table-responsive">
                    <table class="table table-centered table-nowrap mb-0">
                        <thead>
                            <tr>
                                <th>EatApp ID</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($restaurant_cache)): ?>
                                <?php foreach($restaurant_cache as $restaurant): ?>
                                <tr>
                                    <td>
                                        <span class="badge bg-primary"><?=$restaurant->eatapp_id?></span>
                                    </td>
                                    <td>
                                        <h6 class="mb-1"><?=$restaurant->name?></h6>
                                    </td>
                                    <td><?=substr($restaurant->address, 0, 50)?><?=strlen($restaurant->address) > 50 ? '...' : ''?></td>
                                    <td>
                                        <?php if($restaurant->status == 'active'): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?=date('M d, Y', strtotime($restaurant->created_at))?></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-info" onclick="viewCacheData(<?=$restaurant->id?>, 'restaurant')">
                                            <i class="uil-eye"></i> View
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">No restaurant cache entries</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cache Data Modal -->
<div class="modal fade" id="cacheModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cache Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <pre id="cacheDataContent" style="background: #f8f9fa; padding: 15px; border-radius: 5px; max-height: 400px; overflow-y: auto;"></pre>
            </div>
        </div>
    </div>
</div>

<script>
function viewCacheData(id, type) {
    // This would typically load the cache data via AJAX
    // For now, we'll show a placeholder
    document.getElementById('cacheDataContent').innerHTML = `Loading cache data for ${type} ID: ${id}...`;
    new bootstrap.Modal(document.getElementById('cacheModal')).show();
    
    // In a real implementation, you would fetch the data:
    // fetch(`/api/eatapp/cache/${type}/${id}`)
    //     .then(response => response.json())
    //     .then(data => {
    //         document.getElementById('cacheDataContent').innerHTML = JSON.stringify(data, null, 2);
    //     });
}
</script> 