<?php

require_once 'lib/functions.php';

/**
 * Initialize plugin
 */
function discussion_api_plugin_init()
{

    // Expose create function

    elgg_ws_expose_function(
        'discussion.topic.create',
        'topic_create',
        [
            'username' => [
                'type' => 'string',
                'required' => true,
                'description' => 'Username that posts the topic'
            ],
            'title' => [
                'type' => 'string',
                'required' => true,
                'description' => 'Title of the topic'
            ],
            'description' => [
                'type' => 'string',
                'required' => true,
                'description' => 'Description of the topic'
            ],
            'containerGuid' => [
                'type' => 'integer',
                'required' => true,
                'description' => 'Guid of the container (group) of this topic'
            ],
            'timeCreated' => [
                'type' => 'integer',
                'required' => false,
                'description' => 'Epoch the topic was created. Defaults to the current timestamp'
            ],
            'status' => [
                'type' => 'string',
                'required' => false,
                'default' => 'open',
                'description' => 'Status of the topic (open/closed)'
            ],
            'accessLevel' => [
                'type' => 'integer',
                'required' => false,
                'description' => 'Access level of this topic (0: everyone, 1: registered, 3: group members)',
                'default' => 1
            ],
            'tags' => [
                'type' => 'string',
                'required' => false,
                'default' => '',
                'description' => 'Tags of the topic'
            ]
        ],
        'Create a new topic',
        'POST',
        false,
        true,
        true
    );

    elgg_ws_expose_function(
        'discussion.reply.create',
        'reply_create',
        [
            'username' => [
                'type' => 'string',
                'required' => true,
                'description' => 'Username that posts the reply'
            ],
            'topicGuid' => [
                'type' => 'integer',
                'required' => true,
                'description' => 'Guid of the topic to reply'
            ],
            'description' => [
                'type' => 'string',
                'required' => true,
                'description' => 'Description of the reply'
            ],
            'timeCreated' => [
                'type' => 'integer',
                'required' => false,
                'description' => 'Epoch the reply was created. Defaults to the current timestamp'
            ],
        ],
        'Reply to a topic',
        'POST',
        false,
        true,
        true
    );

    /**
     * Expose delete function
     */
    elgg_ws_expose_function(
        'topic.delete',
        'topic_delete',
        [
            'topicTitle' => [
                'type' => 'string',
                'required' => true,
                'description' => 'Title of the topic to reply'
            ],
            'containerGuid' => [
                'type' => 'integer',
                'required' => true,
                'description' => 'Guid of the container (group) of the topic'
            ],
        ],
        'Delete a user',
        'POST',
        false,
        true,
        false
    );
}

elgg_register_event_handler('init', 'system', 'discussion_api_plugin_init');
