<?php

namespace Strativ\BlogExtra\Plugin;

use Strativ\Blog\Observer\LogPostDetailView;

class PreventPostDetailLogger
{
    public function aroundExecute(LogPostDetailView $subject, callable $proceed)
    {
        // Dont do anything to prevent logger from executing
    }
}
