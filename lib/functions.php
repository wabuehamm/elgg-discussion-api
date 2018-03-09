<?php

/**
 * Create a new topic
 *
 * @param $params array Parameters (see start.php for valid parameters)
 * @return bool Success
 * @throws IOException
 * @throws InvalidParameterException
 */
function topic_create($params)
{

    $username = elgg_extract('username', $params);

    $user = get_user_by_username($username);

    if (!$user) {
        throw new APIException('User not found: ' . $user, '-2');
    }

    $title = elgg_extract('title', $params);
    $desc = elgg_extract('description', $params);
    $container_guid = elgg_extract('containerGuid', $params);
    $status = elgg_extract('status', $params);
    $tags = elgg_extract('tags', $params);
    $access_id = elgg_extract('accessLevel', $params);

    $time_created = elgg_extract('timeCreated', $params);


    $topic = new ElggObject();
    $topic->subtype = 'discussion';
    $topic->title = $title;
    $topic->description = $desc;
    $topic->status = $status;
    $topic->access_id = $access_id;
    $topic->container_guid = $container_guid;
    $topic->owner_guid = $user->guid;

    $topic->tags = string_to_tag_array($tags);

    if ($time_created) {
        $topic->time_created = $time_created;
    }

    return $topic->save();

}

/**
 * Create a new topic
 *
 * @param $params array Parameters (see start.php for valid parameters)
 * @return bool Success
 * @throws IOException
 * @throws InvalidParameterException
 */
function reply_create($params)
{

    $username = elgg_extract('username', $params);

    $user = get_user_by_username($username);

    if (!$user) {
        throw new APIException('User not found: ' . $user, '-2');
    }

    $time_created = elgg_extract('timeCreated', $params);
    $topic_guid = elgg_extract('topicGuid', $params);
    $access_id = elgg_extract('accessLevel', $params);

    $desc = elgg_extract('description', $params);

    $reply = new ElggObject();
    $reply->subtype = 'discussion_reply';
    $reply->description = $desc;
    $reply->container_guid = $topic_guid;
    $reply->owner_guid = $user->getGUID();
    $reply->access_id = $access_id;

    if ($time_created) {
        $reply->time_created = $time_created;
    }

    return $reply->save();

}

/**
 * Delete a user by its username
 * @param $username string Username of user to delete
 * @return bool
 */

function topic_delete($username)
{
    $user = get_user_by_username($username);
    if ($user) {
        $user->delete();
        return true;
    } else {
        return false;
    }

}
