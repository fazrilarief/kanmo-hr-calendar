<x-app-layout title="Dashboard Admin">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.26.3/dist/apexcharts.min.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.26.3/dist/apexcharts.min.js"></script>
    <button id="actionBtn">Login KEP</button>

    <script>
        const hashedPassSso = 'MTUyOTM=';

        document.getElementById('actionBtn').addEventListener('click', function() {
            // Check if the token exists in localStorage
            let ssoToken = localStorage.getItem('sso_token');

            if (!ssoToken) {
                // Generate the token first if it's not already available
                generateToken().then(token => {
                    if (token) {
                        localStorage.setItem('sso_token', token);
                        loginWithToken(token);
                    } else {
                        alert('Failed to generate SSO token.');
                    }
                });
            } else {
                // If the token exists, proceed with login
                loginWithToken(ssoToken);
            }
        });

        function generateToken() {
            return fetch(`https://kanmoemployeeportal.com/apiV1/generateSsoToken/${hashedPassSso}`)
                .then(response => response.json())
                .then(data => {
                    if (data.sso_token) {
                        console.log('Generated Token:', data.sso_token);
                        alert(`Generated Token: ${data.sso_token}`);
                        return data.sso_token;
                    } else {
                        console.error('Token generation failed:', data.error);
                        alert('Token generation failed: ' + data.error);
                        return null;
                    }
                })
                .catch(error => {
                    console.error('Error during token generation:', error);
                    alert('Token generation failed');
                    return null;
                });
        }

        function loginWithToken(ssoToken) {
            fetch(`https://kanmoemployeeportal.com/apiV1/login/${hashedPassSso}?sso_token=${ssoToken}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.log('Login failed:', data.error);
                        alert('Login failed: ' + data.error);
                    } else {
                        console.log('Login successful:', data);
                        alert('Login successful');
                        // Open the redirect URL in a new tab
                        if (data.redirect_url) {
                            window.open(data.redirect_url, '_blank');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error during login:', error);
                    alert('Login failed');
                })
                .finally(() => {
                    document.getElementById('actionBtn').innerText = 'Login SSO';
                });
        }
    </script>

    <div class="card my-4">
        <div class="card-header" style="background: #e9500e; color: #ffffff;">
            List Source For Team {{ Auth::guard('admin')->user()->department }}
        </div>
        <div class="card-body">
            <h3>Chart Source</h3>
            <div id="chart" class="mt-3"></div>
            <h3>Chart Feedback</h3>
            <div id="chartRating"></div>
            <h3>Chart Question</h3>
            <div id="chartQuestion"></div>
        </div>
    </div>

    <script>
        var options = {
            chart: {
                type: 'line',
                height: 350,
            },
            series: {!! json_encode(
                $sourcesGrafik->groupBy('source')->map(function ($sourceData) {
                        return [
                            'name' => $sourceData->first()->source,
                            'data' => $sourceData->pluck('total')->toArray(),
                        ];
                    })->values(),
            ) !!},
            xaxis: {
                categories: {!! json_encode($sourcesGrafik->pluck('formatted_date')->unique()->values()) !!}
            },
            yaxis: {
                max: 50,
            },
            legend: {
                show: true,
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>

    <script>
        var options = {
            chart: {
                type: 'line',
                height: 350,
            },
            series: {!! json_encode(
                $ratingsGrafik->groupBy('source')->map(function ($grafikData) {
                        $name = $grafikData->first()->source;
                        $ratings = $grafikData->pluck('rating')->unique()->sort();

                        $nameWithRating = $name . ', Rating: ' . $ratings->implode(', ');

                        return [
                            'name' => $nameWithRating,
                            'data' => $grafikData->pluck('total')->toArray(),
                        ];
                    })->values(),
            ) !!},
            xaxis: {
                categories: {!! json_encode($ratingsGrafik->pluck('formatted_date')->unique()->values()) !!}
            },
            yaxis: {
                max: 50,
            },
            legend: {
                show: true,
            }
        };

        var chart = new ApexCharts(document.querySelector("#chartRating"), options);
        chart.render();
    </script>

    <script>
        var options = {
            chart: {
                type: 'line',
                height: 350,
            },
            series: {!! json_encode(
                $questionGrafik->groupBy('department')->map(function ($departmentData) {
                        return [
                            'name' => $departmentData->first()->department,
                            'data' => $departmentData->pluck('total')->toArray(),
                        ];
                    })->values(),
            ) !!},
            xaxis: {
                categories: {!! json_encode($questionGrafik->pluck('formatted_date')->unique()->values()) !!}
            },
            yaxis: {
                max: 50,
            },
            legend: {
                show: true,
            }
        };

        var chart = new ApexCharts(document.querySelector("#chartQuestion"), options);
        chart.render();
    </script>
</x-app-layout>
