import pandas as pd
import os

excel_dir = 'excel'
files = ['user.xlsx', 'group_list.xlsx', 'group_detail (1).xlsx', 'topic.xlsx', 'group_topic.xlsx', 'member_group.xlsx', 'event_list.xlsx', 'reviews_list.xlsx']

for file in files:
    filepath = os.path.join(excel_dir, file)
    if os.path.exists(filepath):
        print(f"\n=== {file} ===")
        try:
            df = pd.read_excel(filepath, nrows=2)
            print("Columns:", list(df.columns))
            print(f"Shape: {df.shape}")
            print(df.head(1).to_string())
        except Exception as e:
            print(f"Error: {e}")
    else:
        print(f"\n{file} not found")
