<?php

namespace Lw\Application\Service\Wish;

use Lw\Domain\Model\User\UserDoesNotExistException;
use Lw\Domain\Model\User\UserId;

class AddWishServiceAggregateVersion extends WishService
{
    /**
     * @param AddWishRequest $request
     *
     * @return mixed|void
     *
     * @throws UserDoesNotExistException
     */
    public function execute($request = null)
    {
        $userId = $request->userId();
        $address = $request->email();
        $content = $request->content();

        $user = $this->userRepository->ofId(new UserId($userId));
        if (null === $user) {
            throw new UserDoesNotExistException();
        }

        $user->makeWishBeingAnAggregate(
            $this->wishRepository->nextIdentity(),
            $address,
            $content
        );
    }
}
