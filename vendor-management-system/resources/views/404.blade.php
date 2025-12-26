<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <style>
        :root {
            --primary-dark: #080F5C;
            --primary: #334EAC;
            --primary-light: #7086D1;
            --bg-light: #E7E8FF;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #F9FAFF 0%, #E7E8FF 100%);
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        
        .error-container {
            text-align: center;
            padding: 40px;
            max-width: 600px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(8, 15, 92, 0.1);
            border: 1px solid var(--bg-light);
        }
        
        .error-icon {
            font-size: 80px;
            color: var(--primary-light);
            margin-bottom: 20px;
        }
        
        h1 {
            color: var(--primary-dark);
            font-size: 48px;
            margin: 0 0 10px 0;
        }
        
        h2 {
            color: var(--primary);
            font-size: 24px;
            margin: 0 0 20px 0;
            font-weight: 500;
        }
        
        p {
            color: #666;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: var(--primary);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }
        
        .btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(51, 78, 172, 0.3);
        }
        
        .btn-secondary {
            background: white;
            color: var(--primary);
            border: 2px solid var(--bg-light);
        }
        
        .btn-secondary:hover {
            background: var(--bg-light);
            border-color: var(--primary-light);
        }
        
        .btn-group {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .error-code {
            font-size: 120px;
            font-weight: 800;
            color: var(--primary-light);
            opacity: 0.2;
            margin-bottom: 20px;
        }
        
        @media (max-width: 768px) {
            .error-container {
                margin: 20px;
                padding: 30px;
            }
            
            .error-code {
                font-size: 80px;
            }
            
            h1 {
                font-size: 36px;
            }
            
            .btn-group {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="error-container">
        <div class="error-code">404</div>
        <div class="error-icon">
            <i class="bi bi-exclamation-octagon"></i>
        </div>
        <h1>Oops! Page Not Found</h1>
        <h2>We couldn't find what you're looking for</h2>
        <p>The page you are trying to access might have been moved, deleted, or never existed. Please check the URL or navigate back to the home page.</p>
        
        <div class="btn-group">
            <a href="{{ url('/') }}" class="btn">
                <i class="bi bi-house"></i> Go to Homepage
            </a>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Go Back
            </a>
        </div>
    </div>
</body>
</html>