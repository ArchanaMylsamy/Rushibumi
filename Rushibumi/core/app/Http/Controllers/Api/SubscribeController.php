<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Subscriber;
use App\Models\UserNotification;
use App\Constants\Status;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{
    /**
     * Subscribe/Unsubscribe to a channel
     */
    public function toggle(Request $request, $userId)
    {
        $user = User::active()->where('id', $userId)->first();

        if (!$user) {
            return responseError('user_not_found', ['User not found']);
        }

        $authUser = $request->user();

        if ($user->id == $authUser->id) {
            return responseError('cannot_subscribe_self', ['You cannot subscribe to your own channel']);
        }

        $existingSubscription = $user->subscribers()->where('following_id', $authUser->id)->first();

        if ($existingSubscription) {
            // Unsubscribe
            $existingSubscription->delete();
            $subscriberCount = $user->subscribers()->count();

            return responseSuccess('unsubscribed', 'Successfully unsubscribed from channel', [
                'is_subscribed' => false,
                'subscriber_count' => $subscriberCount,
                'channel' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'channel_name' => $user->channel_name,
                    'slug' => $user->slug,
                ]
            ]);
        } else {
            // Subscribe
            $subscriber = new Subscriber();
            $subscriber->user_id = $user->id;
            $subscriber->following_id = $authUser->id;
            $subscriber->save();

            // Create notification for channel owner
            $userNotification = new UserNotification();
            $userNotification->user_id = $user->id;
            $userNotification->title = $authUser->fullname . ' subscribed to your channel.';
            $userNotification->click_url = '#';
            $userNotification->save();

            $subscriberCount = $user->subscribers()->count();

            return responseSuccess('subscribed', 'Successfully subscribed to channel', [
                'is_subscribed' => true,
                'subscriber_count' => $subscriberCount,
                'channel' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'channel_name' => $user->channel_name,
                    'slug' => $user->slug,
                ]
            ]);
        }
    }

    /**
     * Subscribe to a channel
     */
    public function subscribe(Request $request, $userId)
    {
        $user = User::active()->where('id', $userId)->first();

        if (!$user) {
            return responseError('user_not_found', ['User not found']);
        }

        $authUser = $request->user();

        if ($user->id == $authUser->id) {
            return responseError('cannot_subscribe_self', ['You cannot subscribe to your own channel']);
        }

        $existingSubscription = $user->subscribers()->where('following_id', $authUser->id)->first();

        if ($existingSubscription) {
            return responseError('already_subscribed', ['You are already subscribed to this channel']);
        }

        $subscriber = new Subscriber();
        $subscriber->user_id = $user->id;
        $subscriber->following_id = $authUser->id;
        $subscriber->save();

        // Create notification for channel owner
        $userNotification = new UserNotification();
        $userNotification->user_id = $user->id;
        $userNotification->title = $authUser->fullname . ' subscribed to your channel.';
        $userNotification->click_url = '#';
        $userNotification->save();

        $subscriberCount = $user->subscribers()->count();

        return responseSuccess('subscribed', 'Successfully subscribed to channel', [
            'is_subscribed' => true,
            'subscriber_count' => $subscriberCount,
            'channel' => [
                'id' => $user->id,
                'username' => $user->username,
                'channel_name' => $user->channel_name,
                'slug' => $user->slug,
                'image' => getImage(getFilePath('userProfile') . '/' . $user->image, getFileSize('userProfile')),
            ]
        ]);
    }

    /**
     * Unsubscribe from a channel
     */
    public function unsubscribe(Request $request, $userId)
    {
        $user = User::active()->where('id', $userId)->first();

        if (!$user) {
            return responseError('user_not_found', ['User not found']);
        }

        $authUser = $request->user();

        $existingSubscription = $user->subscribers()->where('following_id', $authUser->id)->first();

        if (!$existingSubscription) {
            return responseError('not_subscribed', ['You are not subscribed to this channel']);
        }

        $existingSubscription->delete();
        $subscriberCount = $user->subscribers()->count();

        return responseSuccess('unsubscribed', 'Successfully unsubscribed from channel', [
            'is_subscribed' => false,
            'subscriber_count' => $subscriberCount,
            'channel' => [
                'id' => $user->id,
                'username' => $user->username,
                'channel_name' => $user->channel_name,
                'slug' => $user->slug,
            ]
        ]);
    }

    /**
     * Get subscription status
     */
    public function status(Request $request, $userId)
    {
        $user = User::active()->where('id', $userId)->first();

        if (!$user) {
            return responseError('user_not_found', ['User not found']);
        }

        $authUser = $request->user();
        $isSubscribed = $user->subscribers()->where('following_id', $authUser->id)->exists();

        return responseSuccess('subscription_status', 'Subscription status fetched successfully', [
            'is_subscribed' => $isSubscribed,
            'subscriber_count' => $user->subscribers()->count(),
            'channel' => [
                'id' => $user->id,
                'username' => $user->username,
                'channel_name' => $user->channel_name,
                'slug' => $user->slug,
                'image' => getImage(getFilePath('userProfile') . '/' . $user->image, getFileSize('userProfile')),
            ]
        ]);
    }

    /**
     * Get user's subscriptions (channels user is subscribed to)
     */
    public function mySubscriptions(Request $request)
    {
        $user = $request->user();
        $perPage = $request->get('per_page', 20);
        $page = $request->get('page', 1);

        $subscriptions = Subscriber::where('following_id', $user->id)
            ->with(['followUser' => function ($q) {
                $q->select('id', 'username', 'channel_name', 'slug', 'image', 'firstname', 'lastname', 'display_name');
            }])
            ->whereHas('followUser', function ($query) {
                $query->active();
            })
            ->latest()
            ->paginate($perPage, ['*'], 'page', $page);

        $channels = $subscriptions->getCollection()->map(function ($subscription) {
            $channel = $subscription->followUser;
            if (!$channel) {
                return null;
            }

            return [
                'id' => $channel->id,
                'username' => $channel->username,
                'channel_name' => $channel->channel_name,
                'slug' => $channel->slug,
                'image' => getImage(getFilePath('userProfile') . '/' . $channel->image, getFileSize('userProfile')),
                'display_name' => $channel->display_name ?? ($channel->firstname . ' ' . $channel->lastname),
                'subscriber_count' => $channel->subscribers()->count(),
                'video_count' => $channel->videos()->published()->count(),
                'subscribed_at' => $subscription->created_at->toISOString(),
            ];
        })->filter();

        return responseSuccess('subscriptions_fetched', 'Subscriptions fetched successfully', [
            'channels' => $channels->values(),
            'pagination' => [
                'current_page' => $subscriptions->currentPage(),
                'last_page' => $subscriptions->lastPage(),
                'per_page' => $subscriptions->perPage(),
                'total' => $subscriptions->total(),
                'from' => $subscriptions->firstItem(),
                'to' => $subscriptions->lastItem(),
            ]
        ]);
    }

    /**
     * Get channel's subscribers (users subscribed to a channel)
     */
    public function subscribers(Request $request, $userId)
    {
        $user = User::active()->where('id', $userId)->first();

        if (!$user) {
            return responseError('user_not_found', ['User not found']);
        }

        $authUser = $request->user();

        // Only channel owner can see their subscribers
        if ($user->id != $authUser->id) {
            return responseError('unauthorized', ['You can only view subscribers of your own channel']);
        }

        $perPage = $request->get('per_page', 20);
        $page = $request->get('page', 1);

        $subscribers = Subscriber::where('user_id', $user->id)
            ->with(['followingUser' => function ($q) {
                $q->select('id', 'username', 'firstname', 'lastname', 'display_name', 'image');
            }])
            ->whereHas('followingUser', function ($query) {
                $query->active();
            })
            ->latest()
            ->paginate($perPage, ['*'], 'page', $page);

        $subscriberList = $subscribers->getCollection()->map(function ($subscriber) {
            $subscriberUser = $subscriber->followingUser;
            if (!$subscriberUser) {
                return null;
            }

            return [
                'id' => $subscriberUser->id,
                'username' => $subscriberUser->username,
                'display_name' => $subscriberUser->display_name ?? ($subscriberUser->firstname . ' ' . $subscriberUser->lastname),
                'image' => getImage(getFilePath('userProfile') . '/' . $subscriberUser->image, getFileSize('userProfile')),
                'subscribed_at' => $subscriber->created_at->toISOString(),
            ];
        })->filter();

        return responseSuccess('subscribers_fetched', 'Subscribers fetched successfully', [
            'subscribers' => $subscriberList->values(),
            'pagination' => [
                'current_page' => $subscribers->currentPage(),
                'last_page' => $subscribers->lastPage(),
                'per_page' => $subscribers->perPage(),
                'total' => $subscribers->total(),
                'from' => $subscribers->firstItem(),
                'to' => $subscribers->lastItem(),
            ]
        ]);
    }
}

