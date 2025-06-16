<?php

class EstacionCaretaker {
    private ?EstacionMemento $memento = null;

    public function addMemento(EstacionMemento $memento): void {
        $this->memento = $memento;
    }

    public function getMemento(): ?EstacionMemento {
        return $this->memento;
    }
}
