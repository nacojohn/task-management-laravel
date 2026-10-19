<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? config('app.name', 'Task Management') }}</title>
        <style>
            :root { color-scheme: light; }
            * { box-sizing: border-box; }
            body {
                margin: 0;
                font-family: "Instrument Sans", ui-sans-serif, system-ui, sans-serif;
                background: #FDFDFC;
                color: #1b1b18;
                min-height: 100vh;
            }
            .container { max-width: 56rem; margin: 0 auto; padding: 2rem 1.5rem; }
            header { display: flex; align-items: center; justify-content: space-between; gap: 1rem; margin-bottom: 2rem; }
            header a.brand { font-size: 1.5rem; font-weight: 700; text-decoration: none; color: inherit; }
            .btn {
                display: inline-block;
                border-radius: 0.375rem;
                padding: 0.5rem 1rem;
                font-size: 0.875rem;
                font-weight: 500;
                text-decoration: none;
                border: 1px solid transparent;
                cursor: pointer;
                background: transparent;
                color: inherit;
            }
            .btn-primary { background: #1b1b18; color: #fff; }
            .btn-secondary { border-color: #e3e3e0; }
            .btn-danger { border-color: #fecaca; color: #b91c1c; }
            .alert { border-radius: 0.375rem; padding: 0.75rem 1rem; font-size: 0.875rem; margin-bottom: 1.5rem; }
            .alert-success { border: 1px solid #bbf7d0; background: #f0fdf4; color: #166534; }
            .alert-error { border: 1px solid #fecaca; background: #fef2f2; color: #991b1b; }
            .alert-error ul { margin: 0; padding-left: 1.25rem; }
            table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
            th, td { padding: 0.75rem 1rem; text-align: left; border-bottom: 1px solid #e3e3e0; }
            th { font-weight: 500; }
            .panel { border: 1px solid #e3e3e0; border-radius: 0.375rem; overflow: hidden; background: #fff; }
            .muted { color: #706f6c; }
            .stack > * + * { margin-top: 1.25rem; }
            label { display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500; }
            input, select, textarea {
                width: 100%;
                border: 1px solid #e3e3e0;
                border-radius: 0.375rem;
                padding: 0.5rem 0.75rem;
                font: inherit;
                background: #fff;
            }
            .actions { display: flex; gap: 0.75rem; flex-wrap: wrap; }
            h1 { margin: 0 0 1.5rem; font-size: 1.25rem; }
            a { color: inherit; }
            .capitalize { text-transform: capitalize; }
            .show-header { display: flex; justify-content: space-between; gap: 1rem; margin-bottom: 1.5rem; }
            dl { margin: 0; }
            dl > div + div { margin-top: 1rem; }
            dt { font-size: 0.875rem; font-weight: 500; color: #706f6c; }
            dd { margin: 0.25rem 0 0; font-size: 0.875rem; white-space: pre-wrap; }
            .list-group {
                list-style: none;
                margin: 0;
                padding: 0;
                border: 1px solid #e3e3e0;
                border-radius: 0.375rem;
                background: #fff;
                overflow: hidden;
            }
            .list-group-item {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                padding: 0.875rem 1rem;
                border-bottom: 1px solid #e3e3e0;
                background: #fff;
            }
            .list-group-item:last-child { border-bottom: 0; }
            .list-group-item.sortable-ghost { opacity: 0.5; background: #f5f5f4; }
            .list-group-item.sortable-chosen { background: #fafaf9; }
            .handle {
                user-select: none;
                color: #706f6c;
                font-size: 1.125rem;
                line-height: 1;
            }
            .badge {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-width: 1.75rem;
                padding: 0.15rem 0.5rem;
                border-radius: 999px;
                font-size: 0.75rem;
                font-weight: 600;
            }
            .bg-secondary { background: #e7e5e4; color: #1b1b18; }
            .me-3 { margin-inline-end: 0; }
            .d-flex { display: flex; }
            .align-items-center { align-items: center; }
        </style>
    </head>
    <body>
        <div class="container">
            <header>
                <a href="{{ route('tasks.index') }}" class="brand">Task Management</a>
                <a href="{{ route('tasks.create') }}" class="btn btn-primary">New Task</a>
            </header>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{ $slot }}
        </div>
    </body>
</html>
