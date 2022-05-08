<?php

namespace AsyncAPI\Messages;

class UserSignedUp extends MessageContract
{
    /** @varstring $displayName */
    private $displayName;
    /** @varstring $email */
    private $email;
    /**
     * @param string $id
     * @return MessageContract
     */
    public function setDisplayName(string $displayName): MessageContract
    {
        $this->displayName = $displayName;
        return $this;
    }

    /**
    * @return string
    */
    public function getDisplayName(): string
    {
        return $this->displayName;
    }
    /**
     * @param string $id
     * @return MessageContract
     */
    public function setEmail(string $email): MessageContract
    {
        $this->email = $email;
        return $this;
    }

    /**
    * @return string
    */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
    * @return array
    */
    public function getters(): array
    {
        return [
            'displayName' => 'getDisplayName',
            'email' => 'getEmail',
        ];
    }

    /**
    * @return array
    */
    public function setters(): array
    {
        return [
            'displayName' => 'setDisplayName',
            'email' => 'setEmail',
        ];
    }

    /**
    * @return array|mixed
    */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
