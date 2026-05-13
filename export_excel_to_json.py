import pandas as pd
import os
import json

excel_dir = 'excel'
output_dir = 'database/seeders'

# Read all Excel files
users_df = pd.read_excel(os.path.join(excel_dir, 'user.xlsx')).fillna(value='')
groups_df = pd.read_excel(os.path.join(excel_dir, 'group_list.xlsx')).fillna(value='')
group_details_df = pd.read_excel(os.path.join(excel_dir, 'group_detail (1).xlsx')).fillna(value='')
topics_df = pd.read_excel(os.path.join(excel_dir, 'topic.xlsx')).fillna(value='')
group_topics_df = pd.read_excel(os.path.join(excel_dir, 'group_topic.xlsx')).fillna(value='')
member_groups_df = pd.read_excel(os.path.join(excel_dir, 'member_group.xlsx')).fillna(value='')
events_df = pd.read_excel(os.path.join(excel_dir, 'event_list.xlsx')).fillna(value='')
reviews_df = pd.read_excel(os.path.join(excel_dir, 'reviews_list.xlsx')).fillna(value='')

# Create output directory if it doesn't exist
os.makedirs(output_dir, exist_ok=True)

# Convert DataFrames to JSON for seeding
def df_to_json(df):
    return json.loads(df.to_json(orient='records', date_format='iso'))

# Save data as JSON
with open(os.path.join(output_dir, 'users_data.json'), 'w') as f:
    json.dump(df_to_json(users_df), f, indent=2)

with open(os.path.join(output_dir, 'groups_data.json'), 'w') as f:
    json.dump(df_to_json(groups_df), f, indent=2)

with open(os.path.join(output_dir, 'group_details_data.json'), 'w') as f:
    json.dump(df_to_json(group_details_df), f, indent=2)

with open(os.path.join(output_dir, 'topics_data.json'), 'w') as f:
    json.dump(df_to_json(topics_df), f, indent=2)

with open(os.path.join(output_dir, 'group_topics_data.json'), 'w') as f:
    json.dump(df_to_json(group_topics_df), f, indent=2)

with open(os.path.join(output_dir, 'member_groups_data.json'), 'w') as f:
    json.dump(df_to_json(member_groups_df), f, indent=2)

with open(os.path.join(output_dir, 'events_data.json'), 'w') as f:
    json.dump(df_to_json(events_df), f, indent=2)

with open(os.path.join(output_dir, 'reviews_data.json'), 'w') as f:
    json.dump(df_to_json(reviews_df), f, indent=2)

print("Data exported successfully to database/seeders/")
