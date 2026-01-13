
<?php $__env->startSection('content'); ?>
    <div class="dashboard-content">
        <div class="card custom--card">
            <div class="card-header">
                <h3 class="card-title"><?php echo app('translator')->get('Live Streams Database Check'); ?></h3>
            </div>
            <div class="card-body">
                <div id="debugInfo" class="debug-container">
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2"><?php echo app('translator')->get('Loading database information...'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .debug-container {
            font-family: monospace;
        }
        .debug-section {
            margin-bottom: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        .debug-section h4 {
            color: #333;
            margin-bottom: 15px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        .debug-item {
            margin: 10px 0;
            padding: 10px;
            background: #fff;
            border-left: 4px solid #007bff;
            border-radius: 4px;
        }
        .debug-item strong {
            color: #007bff;
        }
        .status-live {
            color: #28a745;
            font-weight: bold;
        }
        .status-ended {
            color: #dc3545;
            font-weight: bold;
        }
        .status-scheduled {
            color: #ffc107;
            font-weight: bold;
        }
        .json-data {
            background: #1e1e1e;
            color: #d4d4d4;
            padding: 15px;
            border-radius: 4px;
            overflow-x: auto;
            max-height: 400px;
            overflow-y: auto;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        const debugData = <?php echo json_encode($debugData ?? [], 15, 512) ?>;
        
        // If data is already available from server, use it, otherwise fetch
        if (debugData && debugData.success) {
            displayDebugInfo(debugData);
        } else {
            fetch('<?php echo e(route("user.live.debug")); ?>', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                displayDebugInfo(data);
            })
            .catch(error => {
                document.getElementById('debugInfo').innerHTML = 
                    `<div class="alert alert-danger">Error: ${error.message}</div>`;
            });
        }

        function displayDebugInfo(data) {
                const container = document.getElementById('debugInfo');
                
                if (data.success) {
                    let html = `
                        <div class="debug-section">
                            <h4><?php echo app('translator')->get('Database Status'); ?></h4>
                            <div class="debug-item">
                                <strong>Table Exists:</strong> ${data.database_check.table_exists ? '<span class="status-live">✓ Yes</span>' : '<span class="status-ended">✗ No</span>'}
                            </div>
                            <div class="debug-item">
                                <strong>Total Streams:</strong> ${data.database_check.total_streams}
                            </div>
                            <div class="debug-item">
                                <strong>Live Streams:</strong> <span class="status-live">${data.database_check.live_streams}</span>
                            </div>
                        </div>

                        <div class="debug-section">
                            <h4><?php echo app('translator')->get('Your Streams'); ?> (${data.user_streams_count})</h4>
                    `;

                    if (data.user_streams.length > 0) {
                        data.user_streams.forEach(stream => {
                            const statusClass = stream.status === 'live' ? 'status-live' : 
                                              stream.status === 'ended' ? 'status-ended' : 'status-scheduled';
                            html += `
                                <div class="debug-item">
                                    <strong>ID:</strong> ${stream.id}<br>
                                    <strong>Title:</strong> ${stream.title}<br>
                                    <strong>Status:</strong> <span class="${statusClass}">${stream.status.toUpperCase()}</span><br>
                                    <strong>Visibility:</strong> ${stream.visibility}<br>
                                    <strong>Started At:</strong> ${stream.started_at || 'N/A'}<br>
                                    <strong>Ended At:</strong> ${stream.ended_at || 'N/A'}<br>
                                    <strong>Viewers:</strong> ${stream.viewers_count}<br>
                                    <strong>Created:</strong> ${stream.created_at}<br>
                                    <strong>Updated:</strong> ${stream.updated_at}
                                </div>
                            `;
                        });
                    } else {
                        html += '<p class="text-muted"><?php echo app('translator')->get("No streams found in database"); ?></p>';
                    }

                    html += '</div>';

                    if (data.recent_streams && data.recent_streams.length > 0) {
                        html += `
                            <div class="debug-section">
                                <h4><?php echo app('translator')->get('Recent Streams (All Users)'); ?></h4>
                        `;
                        data.recent_streams.forEach(stream => {
                            const statusClass = stream.status === 'live' ? 'status-live' : 
                                              stream.status === 'ended' ? 'status-ended' : 'status-scheduled';
                            html += `
                                <div class="debug-item">
                                    <strong>ID:</strong> ${stream.id} | 
                                    <strong>Title:</strong> ${stream.title} | 
                                    <strong>Status:</strong> <span class="${statusClass}">${stream.status.toUpperCase()}</span> | 
                                    <strong>User:</strong> ${stream.user}
                                </div>
                            `;
                        });
                        html += '</div>';
                    }

                    html += `
                        <div class="debug-section">
                            <h4><?php echo app('translator')->get('Raw JSON Data'); ?></h4>
                            <pre class="json-data">${JSON.stringify(data, null, 2)}</pre>
                        </div>
                    `;

                    container.innerHTML = html;
                } else {
                    container.innerHTML = '<div class="alert alert-danger">Failed to load debug information</div>';
                }
        }
    </script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Rushibumi\Rushibumi\core\resources\views/templates/basic/user/live/debug.blade.php ENDPATH**/ ?>