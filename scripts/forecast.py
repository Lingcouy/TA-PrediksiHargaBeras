# scripts/forecast.py
import sys
import json
import pandas as pd
import warnings
from pmdarima import auto_arima  # Import auto_arima

# Suppress warnings for cleaner output
warnings.filterwarnings("ignore")

# Read input JSON from PHP
try:
    data_json = sys.stdin.read()
    data = json.loads(data_json)
except json.JSONDecodeError as e:
    print(json.dumps({"error": f"Invalid JSON input: {str(e)}"}))
    sys.exit(1)

# Validate input
required_keys = ['dates', 'values', 'months_ahead']
if not all(key in data for key in required_keys):
    print(json.dumps({"error": "Missing required keys in input"}))
    sys.exit(1)

try:
    # Convert input to pandas Series
    series = pd.Series(
        data['values'],
        index=pd.to_datetime(data['dates'], errors='coerce')
    )

    # Drop any invalid dates
    series = series[series.index.notnull()]

    if len(series) < 3:
        print(json.dumps({"error": "Insufficient data points for ARIMA"}))
        sys.exit(1)

    # Fit ARIMA model using auto_arima with optimizations
    model = auto_arima(
        series,
        seasonal=True,
        m=12,  # Monthly seasonality
        stepwise=True,  # Use stepwise search for faster fitting
        suppress_warnings=True,
        max_order=None,  # Allow auto_arima to determine the best order
        max_p=5,  # Limit maximum p
        max_q=5,  # Limit maximum q
        trace=False  # Disable trace output for cleaner logs
    )

    # Forecast
    forecast, conf_int = model.predict(n_periods=data['months_ahead'], return_conf_int=True)

    # Output as JSON
    print(json.dumps({
        "forecast": forecast.tolist(),
        "dates": [(pd.Timestamp.now() + pd.DateOffset(months=i)).strftime('%Y-%m-%d') for i in range(1, data['months_ahead'] + 1)]
    }))
except Exception as e:
    print(json.dumps({"error": f"ARIMA processing error: {str(e)}"}))
    sys.exit(1)
