<?php

namespace Exdeliver\Causeway\Domain\Entities\Page;

use VanOns\Laraberg\Events\ContentCreated;
use VanOns\Laraberg\Events\ContentUpdated;
use VanOns\Laraberg\Helpers\BlockHelper;
use VanOns\Laraberg\Helpers\EmbedHelper;
use VanOns\Laraberg\Models\Content;
use VanOns\Laraberg\Models\Content as LaContent;

/**
 * Trait CustomGutenbergTrait
 * @package Exdeliver\Causeway\Domain\Entities\Page
 */
trait CustomGutenbergTrait
{
    /**
     * Returns the rendered HTML from the Content object
     * @return String
     */
    public function renderContent()
    {
        return $this->body->render();
    }

    /**
     * Returns the raw content that came out of Gutenberg
     * @return String
     */
    public function getRawContent()
    {
        return $this->body->raw_content;
    }

    /**
     * Returns the Gutenberg content with some initial rendering done to it
     * @return String
     */
    public function getRenderedContent()
    {
        return $this->body->rendered_content;
    }

    /**
     * @return string
     */
    public function transform()
    {
        $html = BlockHelper::renderBlocks(EmbedHelper::renderEmbeds($this->content));
        return "<div class='gutenberg__content wp-embed-responsive'>$html</div>";
    }

    /**
     * Sets the content object using the raw editor content
     * @param String $content
     * @param String $save - Calls .save() on the Content object if true
     */
    public function setContent($content, $save = false)
    {
        if (!$this->body) {
            $this->createContent();
        }

        $this->body->setContent($content);
        if ($save) {
            $this->body->save();
        }
        event(new ContentUpdated($this->body));
    }

    /**
     * Creates a content object and associates it with the parent object
     */
    private function createContent()
    {
        $content = new Content;
        $this->body()->save($content);
        $this->body = $content;
        event(new ContentCreated($content));
    }

    public function body()
    {
        return $this->morphOne(LaContent::class, 'contentable');
    }
}
