<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="miksoft.pro">
    <title>BeeJee test task</title>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/custom.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand mr-auto mr-lg-0" href="/">BeeJee task project</a>
        <div class="navbar-collapse offcanvas-collapse">
            <div class="navbar-nav mr-auto"></div>
            <div class="my-2 my-lg-0">
                <?php if ( ! $user || empty($user['user_id'])): ?>
                    <a href="/login" title="" class="btn btn-outline-success my-2 my-sm-0">Login</a>
                <?php else: ?>
                    <span class="hello-user">Hello, <b><?= $user['user_name'] ?></b></span> <a href="/logout" title="" class="btn btn-outline-success my-2 my-sm-0">Logout</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <main role="main" class="container">
        <div class="my-3 p-3 bg-white rounded shadow-sm">
            <h6 class="border-bottom border-gray pb-2 mb-0"><?= isset($taskData) ? 'Edit' : 'Add new' ?> task</h6>
            <form class="mt-md-3" action="/save" method="post" id="taskform">
                <div class="form-row">
                    <div class="col-md-6">
                        <input type="text" name="task_name" class="form-control" value="<?= isset($taskData) ? $taskData['task_name'] : '' ?>" placeholder="Your name" required>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="task_email" class="form-control" value="<?= isset($taskData) ? $taskData['task_email'] : '' ?>" placeholder="Your email" required>
                    </div>
                </div>
                <div class="mt-md-3">
                    <textarea class="form-control" name="task_text" placeholder="Task description" required><?= isset($taskData) ? $taskData['task_text'] : '' ?></textarea>
                </div>
                <?php if (isset($taskData)): ?>
                <div class="form-check mt-md-3">
                    <input class="form-check-input" type="checkbox" value="1" name="task_status" id="taskCompleted" <?= isset($taskData) && $taskData['task_status'] == 1 ? 'checked' : '' ?>>
                    <label class="form-check-label" for="taskCompleted">
                        Task completed
                    </label>
                </div>
                <?php endif; ?>
                <div class="mt-3">
                    <button class="btn btn-primary" type="submit"><?= isset($taskData) ? 'Save' : 'Add' ?> task</button>
                    <?php if (isset($taskData)): ?>
                        <button class="btn btn-secondary" type="button" data-role="cancel">Cancel edit</button>
                        <input type="hidden" name="task_id" value="<?= $taskData['task_id'] ?>" />
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <div class="my-3 p-3 bg-white rounded shadow-sm">
            <div class="row">
                <div class="col-md-6">
                    <select class="form-control" name="sort-field">
                        <option value="date"<?= $sort == 'date' ? ' selected' : '' ?>>Sort by date added</option>
                        <option value="name"<?= $sort == 'name' ? ' selected' : '' ?>>Sort by username</option>
                        <option value="email"<?= $sort == 'email' ? ' selected' : '' ?>>Sort by user email</option>
                        <option value="text"<?= $sort == 'text' ? ' selected' : '' ?>>Sort by task description</option>
                        <option value="status"<?= $sort == 'status' ? ' selected' : '' ?>>Sort by task status</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <select class="form-control" name="sort-order">
                        <option value="asc"<?= $order == 'asc' ? ' selected' : '' ?>>Ascending</option>
                        <option value="desc"<?= $order == 'desc' ? ' selected' : '' ?>>Descending</option>
                    </select>
                </div>
            </div>
            <?php if ( ! empty($tasks) && is_array($tasks)): ?>
                <?php foreach ($tasks as $item): ?>
                    <div class="media text-muted pt-3">
                        <svg class="bd-placeholder-img mr-2 rounded" width="32" height="32" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32">
                            <rect width="100%" height="100%" fill="<?= $item['task_status'] == 1 ? '#29d229' : '#e83e8c' ?>"/>
                        </svg>
                        <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                            <strong class="d-block text-gray-dark">
                                <?= $item['task_name'] ?> (<?= $item['task_email'] ?>) <?= ( ! empty($user) && ! empty($user['user_id']) ? '<a href="?edit=' . $item['task_id'] . '&page=' . $page . '" title="">Edit</a>' : '') ?>
                            </strong>
                            <?php if ($item['task_status']): ?>
                                <span class="badge badge-success">Completed</span>
                            <?php else: ?>
                                <span class="badge badge-danger">In progress</span>
                            <?php endif; ?>
                            <?= $item['task_text'] ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <nav class="mb-5">
            <?= isset($paginator) ? $paginator : null ?>
        </nav>
    </main>
    <script src="/assets/js/jquery-3.5.0.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
    <script src="/assets/js/jquery.form.min.js"></script>
    <script src="/assets/js/jquery.validate.min.js"></script>
    <script>
        $('[name="sort-field"]').on('change', function() {
            location.href = '?page=<?= $page ?>&sort=' + $( this ).val() + '&order=<?= $order ?>';
        });

        $('[name="sort-order"]').on('change', function() {
            location.href = '?page=<?= $page ?>&sort=<?= $sort ?>&order=' + $( this ).val();
        });

        $('[data-role="cancel"]').on('click', () => {
            location.href = '/?page=<?= $page ?>';
        });

        $("#taskform").validate({
            errorClass: 'is-invalid',
            validClass: 'is-valid',
            rules: {
                'task_name': {
                    required: true
                },
                'task_email': {
                    required: true,
                    email: true
                },
                'task_text': {
                    required: true
                }
            },
            messages: {
                'task_name': {
                    required: 'Enter your name'
                },
                'task_email': {
                    required: 'Enter your email',
                    email: 'Enter valid email'
                },
                'task_text': {
                    required: 'Write a task text'
                },
            },
            submitHandler: function(form) {
                $(form).ajaxSubmit({
                    dataType: "json",
                    beforeSubmit: function() {
                        $(form).find('[type="submit"]').addClass('disabled');
                    },
                    success: function(data) {
                        if (data.status != true)
                        {
                            alert(data.error);
                        }
                        else
                        {
                            alert('Task successfully save. Please wait, the page will be updated.');
                            location.reload();
                        }
                    }
                });
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass(errorClass).removeClass(validClass);
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass(errorClass).addClass(validClass);
            }
        });
    </script>
</html>
