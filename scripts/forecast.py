# scripts/forecast.py
import sys
import json
import pandas as pd
from statsmodels.tsa.arima.model import ARIMA
import warnings

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

    # Fit ARIMA model (order can be tuned or passed as parameter)
    model = ARIMA(series, order=(1, 1, 1))  # Adjust order as needed
    model_fit = model.fit()

    #from pmdarima import auto_arima
    # # Replace the ARIMA model line
    # model = auto_arima(series, seasonal=True, m=12, suppress_warnings=True)
    # model_fit = model.fit()
    # forecast = model_fit.predict(n_periods=data['months_ahead'])

    # Forecast
    forecast = model_fit.forecast(steps=data['months_ahead'])

    # Output as JSON
    print(json.dumps({
        "forecast": forecast.tolist(),
        "dates": [d.strftime('%Y-%m-%d') for d in forecast.index]
    }))
except Exception as e:
    print(json.dumps({"error": f"ARIMA processing error: {str(e)}"}))
    sys.exit(1)
