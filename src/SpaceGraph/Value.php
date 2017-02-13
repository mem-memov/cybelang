<?php

namespace MemMemov\SpaceGraph;

interface Value extends Node
{
    public function getContents(): string;
}