<?php
$page_title = "App Settings";
include_once 'common/header.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_app_name = trim($_POST['app_name']);
    if (!empty($new_app_name)) {
        $stmt = $conn->prepare("UPDATE settings SET setting_value = ? WHERE setting_key = 'app_name'");
        $stmt->bind_param("s", $new_app_name);
        if ($stmt->execute()) {
            $message = "Settings updated successfully!";
            $app_name = $new_app_name; // Update variable for current page
        } else {
            $message = "Error updating settings.";
        }
        $stmt->close();
    } else {
        $message = "App name cannot be empty.";
    }
}
?>

<div class="max-w-2xl mx-auto">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-slate-800 mb-4">General Settings</h2>

        <?php if ($message): ?>
            <div class="p-3 mb-4 rounded-md <?= strpos($message, 'Error') !== false ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="setting.php">
            <div class="mb-4">
                <label for="app_name" class="block text-sm font-medium text-slate-700">App Name</label>
                <input type="text" name="app_name" id="app_name" value="<?= htmlspecialchars($app_name) ?>" class="mt-1 block w-full px-3 py-2 border border-slate-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500" required>
            </div>
            
            <!-- Future settings can be added here -->

            <div class="flex justify-end">
                <button type="submit" class="bg-purple-600 text-white px-4 py-2 rounded-md hover:bg-purple-700 transition-colors">
                    Save Settings
                </button>
            </div>
        </form>
    </div>
</div>

<?php include_once 'common/bottom.php'; ?>