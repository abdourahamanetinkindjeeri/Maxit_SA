<?php if (!empty($signupError)): ?>
    <div class="bg-red-900 bg-opacity-50 border border-red-500 rounded-xl p-4 mb-6 w-full max-w-md">
        <div class="flex items-center">
            <svg class="h-5 w-5 text-red-400 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <span class="text-red-300 text-sm"><?= htmlspecialchars($signupError) ?></span>
        </div>
    </div>
<?php endif; ?>

<?php if (!empty($successMessage)): ?>
    <div class="bg-green-900 bg-opacity-50 border border-green-500 rounded-xl p-4 mb-6 w-full max-w-md">
        <div class="flex items-center">
            <svg class="h-5 w-5 text-green-400 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span class="text-green-300 text-sm"><?= htmlspecialchars($successMessage) ?></span>
        </div>
    </div>
<?php endif; ?> 