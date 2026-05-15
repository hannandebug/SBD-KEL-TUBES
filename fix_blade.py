#!/usr/bin/env python3
# -*- coding: utf-8 -*-

# Read the file with UTF-8 encoding
with open('resources/views/index.blade.php', 'r', encoding='utf-8') as f:
    lines = f.readlines()

# Convert to list for easier manipulation
output_lines = []
i = 0
while i < len(lines):
    line = lines[i]
    
    # Pattern 1: Featured Groups - Replace the <a> tag wrapping featured-group-card
    if '<a href="{{ route(\'group.detail\'' in line and 'class="featured-group-card"' in line:
        # This is the featured groups anchor tag
        # Replace it with a div and move the anchor inside
        indent = len(line) - len(line.lstrip())
        output_lines.append(' ' * indent + '<div class="featured-group-card">\n')
        output_lines.append(' ' * (indent + 4) + '<a href="{{ route(\'group.detail\', [\'id\' => $group->id_group]) }}" style="text-decoration: none; color: inherit;">\n')
        
        # Copy the card content until we find the closing </a>
        i += 1
        while i < len(lines) and '</a>' not in lines[i]:
            output_lines.append(lines[i])
            i += 1
        
        # Now add the closing anchor and overlay
        if i < len(lines) and '</a>' in lines[i]:
            output_lines.append(' ' * (indent + 4) + '</a>\n')
            output_lines.append(' ' * (indent + 4) + '<div class="card-overlay">\n')
            output_lines.append(' ' * (indent + 8) + '@if(Auth::check())\n')
            output_lines.append(' ' * (indent + 8) + '<form action="{{ route(\'group.join\', [\'id\' => $group->id_group]) }}" method="POST" style="display: inline;">\n')
            output_lines.append(' ' * (indent + 12) + '@csrf\n')
            output_lines.append(' ' * (indent + 12) + '<button type="submit" class="btn-join">Join Group</button>\n')
            output_lines.append(' ' * (indent + 8) + '</form>\n')
            output_lines.append(' ' * (indent + 8) + '@else\n')
            output_lines.append(' ' * (indent + 8) + '<a href="{{ route(\'login\') }}" class="btn-join">Login to Join</a>\n')
            output_lines.append(' ' * (indent + 8) + '@endif\n')
            output_lines.append(' ' * (indent + 4) + '</div>\n')
            output_lines.append(' ' * indent + '</div>\n')
            i += 1
    
    # Pattern 2: Upcoming Events - Replace the <a> tag wrapping event cards
    elif '<a href="{{ route(\'event.detail\'' in line and 'style="text-decoration: none; color: inherit;"' in line:
        # Check if this is not already wrapped
        if i > 0 and 'event-card-wrapper' not in lines[i - 1]:
            # This is the events anchor tag that needs wrapping
            indent = len(line) - len(line.lstrip())
            output_lines.append(' ' * indent + '<div class="event-card-wrapper">\n')
            output_lines.append(line)
            
            # Copy the event card content until we find the closing </a>
            i += 1
            while i < len(lines) and '</a>' not in lines[i]:
                output_lines.append(lines[i])
                i += 1
            
            # Now add the closing anchor and overlay
            if i < len(lines) and '</a>' in lines[i]:
                output_lines.append(' ' * indent + '</a>\n')
                output_lines.append(' ' * (indent + 4) + '<div class="card-overlay">\n')
                output_lines.append(' ' * (indent + 8) + '@if(Auth::check())\n')
                output_lines.append(' ' * (indent + 8) + '<form action="{{ route(\'event.rsvp\', [\'id\' => $event->id_event]) }}" method="POST" style="display: inline;">\n')
                output_lines.append(' ' * (indent + 12) + '@csrf\n')
                output_lines.append(' ' * (indent + 12) + '<button type="submit" class="btn-join">RSVP</button>\n')
                output_lines.append(' ' * (indent + 8) + '</form>\n')
                output_lines.append(' ' * (indent + 8) + '@else\n')
                output_lines.append(' ' * (indent + 8) + '<a href="{{ route(\'login\') }}" class="btn-join">Login to RSVP</a>\n')
                output_lines.append(' ' * (indent + 8) + '@endif\n')
                output_lines.append(' ' * (indent + 4) + '</div>\n')
                output_lines.append(' ' * indent + '</div>\n')
                i += 1
        else:
            output_lines.append(line)
            i += 1
    else:
        output_lines.append(line)
        i += 1

# Write the modified content back
with open('resources/views/index.blade.php', 'w', encoding='utf-8') as f:
    f.writelines(output_lines)

print("File updated successfully!")

