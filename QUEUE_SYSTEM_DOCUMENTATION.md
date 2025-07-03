# Container Queue Management System

## Overview

This system implements a **FIRST COME FIRST SERVE (FCFS) + Priority Scheduler** algorithm for managing container processing queues. The system prioritizes containers based on their priority level (High > Normal) and then processes them in the order of their entry date within the same priority level.

## Algorithm Implementation

### Priority + FCFS Logic

The `ContainerQueueService` class implements the following algorithm:

1. **Primary Sort**: By Priority Level

    - `High` priority containers are processed first
    - `Normal` priority containers are processed second

2. **Secondary Sort**: By Entry Date (FCFS)

    - Within the same priority level, containers are ordered by `entry_date`
    - Earlier entry dates are processed first

### Code Implementation

```php
protected function sortByPriorityAndFCFS(Collection $containers): Collection
{
    return $containers->sort(function ($a, $b) {
        // First, compare by priority (High priority first)
        $priorityA = self::PRIORITY_ORDER[$a->priority] ?? 999;
        $priorityB = self::PRIORITY_ORDER[$b->priority] ?? 999;

        if ($priorityA !== $priorityB) {
            return $priorityA <=> $priorityB;
        }

        // If same priority, use FCFS (earliest entry_date first)
        $entryDateA = $a->entry_date ? $a->entry_date->timestamp : 0;
        $entryDateB = $b->entry_date ? $b->entry_date->timestamp : 0;

        return $entryDateA <=> $entryDateB;
    })->values();
}
```

## Service Features

### Core Methods

#### Queue Management

-   `getQueuedContainers()` - Get all containers in queue with filters and pagination
-   `getPendingQueue()` - Get only pending containers
-   `getNextContainer()` - Get the next container to be processed
-   `getQueuePosition()` - Get position of a specific container in queue

#### Processing Control

-   `processNext()` - Start processing the next container in queue
-   `completeProcessing()` - Mark a container as completed

#### Analytics & Statistics

-   `getQueueStatistics()` - Get comprehensive queue statistics
-   `getDetailedQueueInfo()` - Get detailed queue information with positions
-   `simulateQueueProcessing()` - Simulate queue processing for planning

#### Time Calculations

-   `calculateAverageWaitTime()` - Calculate average wait time for pending containers
-   `calculateEstimatedProcessTime()` - Calculate total estimated processing time

## Usage Examples

### 1. Get Next Container to Process

```php
use App\Services\ContainerQueueService;

$queueService = new ContainerQueueService();
$nextContainer = $queueService->getNextContainer();

if ($nextContainer) {
    echo "Next: {$nextContainer->container_number} (Priority: {$nextContainer->priority})";
}
```

### 2. Get Queue Position

```php
$container = Container::find(1);
$position = $queueService->getQueuePosition($container);
echo "Container is at position: {$position}";
```

### 3. Get Queue Statistics

```php
$stats = $queueService->getQueueStatistics();
/*
Returns:
[
    'total_pending' => 15,
    'high_priority_pending' => 5,
    'normal_priority_pending' => 10,
    'average_wait_time_minutes' => 45.5,
    'estimated_total_process_time_minutes' => 450
]
*/
```

### 4. Simulate Queue Processing

```php
$simulation = $queueService->simulateQueueProcessing(10);
/*
Returns detailed simulation with:
- Container order
- Estimated start/completion times
- Wait times
- Priority breakdown
*/
```

## Web Interface

### Queue Management Page

The system includes a comprehensive web interface at `/containers-queue` that provides:

#### Dashboard Features

-   **Real-time Statistics**: Total pending, high priority count, average wait time
-   **Next Container Alert**: Highlighted next container to be processed
-   **Process Control**: One-click buttons to process next container or complete processing

#### Queue Display

-   **Sorted Table**: Shows containers in processing order
-   **Priority Indicators**: Visual badges for High/Normal priority
-   **Wait Time Display**: Human-readable wait times
-   **Status Tracking**: Current status of each container

#### Filtering & Search

-   **Text Search**: Search by container number or customer name
-   **Status Filter**: Filter by pending, in_progress, completed
-   **Priority Filter**: Filter by High or Normal priority
-   **Date Range**: Filter by entry date range

#### Queue Simulation

-   **Processing Simulation**: Interactive simulation showing processing order
-   **Time Estimates**: Estimated start and completion times
-   **Resource Planning**: Visual representation of queue processing timeline

### Controller Integration

The `ContainerController` has been enhanced with queue management methods:

```php
// Display queue management page
public function queue(Request $request)

// Process next container in queue
public function processNext()

// Complete processing of current container
public function completeProcessing(Container $container)

// Get queue simulation data as JSON
public function queueSimulation(Request $request)
```

## Database Schema

### Container Fields Used by Queue System

```sql
CREATE TABLE containers (
    id BIGINT PRIMARY KEY,
    container_number VARCHAR(255) UNIQUE,
    customer_id BIGINT,
    status ENUM('pending', 'in_progress', 'completed', 'cancelled'),
    priority ENUM('High', 'Normal') DEFAULT 'Normal',
    entry_date TIMESTAMP,
    process_start_time TIMESTAMP NULL,
    process_end_time TIMESTAMP NULL,
    exit_date TIMESTAMP NULL,
    estimated_time INT NULL, -- Processing time in minutes
    -- ... other fields
);
```

## API Endpoints

### Queue Management Routes

```php
Route::get('/containers-queue', [ContainerController::class, 'queue'])
    ->name('containers.queue');

Route::post('/containers-queue/process-next', [ContainerController::class, 'processNext'])
    ->name('containers.queue.process-next');

Route::post('/containers/{container}/complete-processing', [ContainerController::class, 'completeProcessing'])
    ->name('containers.complete-processing');

Route::get('/containers-queue/simulation', [ContainerController::class, 'queueSimulation'])
    ->name('containers.queue.simulation');
```

## Queue Processing Workflow

### 1. Container Entry

-   Container arrives and gets `status = 'pending'`
-   `entry_date` is set to current timestamp
-   `priority` is assigned (High or Normal)

### 2. Queue Ordering

-   System automatically orders containers using Priority + FCFS algorithm
-   Queue position is calculated dynamically
-   Wait times are estimated based on position and processing times

### 3. Processing Start

-   Next container is selected using `getNextContainer()`
-   Status changes to `in_progress`
-   `process_start_time` is recorded

### 4. Processing Completion

-   Container processing is completed
-   Status changes to `completed`
-   `process_end_time` and `exit_date` are recorded

## Performance Considerations

### Optimization Features

-   **Lazy Loading**: Uses eager loading with `with('customer')` to prevent N+1 queries
-   **Efficient Sorting**: In-memory sorting after database retrieval for complex priority logic
-   **Pagination**: Built-in pagination support for large queues
-   **Caching Ready**: Service methods are designed to be easily cached

### Scalability Notes

-   For very large queues (1000+ containers), consider implementing database-level sorting
-   Queue positions are calculated on-demand to ensure accuracy
-   Statistics are calculated real-time but can be cached for better performance

## Customization Options

### Adding New Priority Levels

```php
// In ContainerQueueService.php
const PRIORITY_ORDER = [
    'Emergency' => 1,  // New highest priority
    'High' => 2,
    'Normal' => 3,
    'Low' => 4         // New lowest priority
];
```

### Custom Processing Time Estimation

```php
// Override in service class
protected function getEstimatedProcessingTime(Container $container): int
{
    // Custom logic based on container type, size, etc.
    return match($container->type) {
        'large' => 60,
        'medium' => 30,
        'small' => 15,
        default => 30
    };
}
```

## Testing

### Unit Tests

The service is designed to be easily unit tested:

```php
public function test_queue_ordering()
{
    // Create test containers with different priorities and entry dates
    // Assert correct ordering using getQueuedContainers()
}

public function test_next_container_selection()
{
    // Test that getNextContainer() returns correct container
}

public function test_queue_position_calculation()
{
    // Test queue position calculation accuracy
}
```

### Integration Tests

-   Test complete workflow from entry to completion
-   Test web interface functionality
-   Test API endpoints

## Monitoring & Analytics

### Queue Metrics

-   Average wait time by priority level
-   Processing time efficiency
-   Queue length trends
-   Priority distribution

### Performance Metrics

-   Container throughput per hour/day
-   Queue processing velocity
-   Resource utilization

## Troubleshooting

### Common Issues

1. **Incorrect Queue Order**

    - Check priority values in database
    - Verify entry_date timestamps
    - Ensure no duplicate priorities with same entry times

2. **Performance Issues**

    - Monitor queue size and consider pagination
    - Check for proper database indexing on priority and entry_date
    - Consider caching for frequently accessed statistics

3. **Processing Workflow Issues**

    - Verify status transitions are correct
    - Check timestamp fields are being set properly
    - Ensure proper error handling in processing methods

## Future Enhancements

### Potential Features

-   **Real-time Updates**: WebSocket integration for live queue updates
-   **Advanced Scheduling**: Time-based priority adjustments
-   **Resource Allocation**: Multi-resource constraint scheduling
-   **Machine Learning**: Predictive processing time estimation
-   **Mobile Interface**: Mobile-optimized queue management
-   **Notification System**: Automated alerts for queue milestones

This comprehensive queue management system provides a solid foundation for container processing optimization while maintaining flexibility for future enhancements and customizations.
