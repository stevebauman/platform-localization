<?php namespace Stevebauman\Localization\Repositories\Translation;

interface TranslationRepositoryInterface
{

    /**
     * Returns a dataset compatible with data grid.
     *
     * @param int|string $localeId
     * @return \Stevebauman\Localization\Models\Translation
     */
    public function grid($localeId);

    /**
     * Returns all the localization entries.
     *
     * @return \Stevebauman\Localization\Models\Translation
     */
    public function findAll();

    /**
     * Returns a localization entry by its primary key.
     *
     * @param  int $id
     * @return \Stevebauman\Localization\Models\Translation
     */
    public function find($id);

    /**
     * Determines if the given localization is valid for creation.
     *
     * @param  array $data
     * @return \Illuminate\Support\MessageBag
     */
    public function validForCreation(array $data);

    /**
     * Determines if the given localization is valid for update.
     *
     * @param  int $id
     * @param  array $data
     * @return \Illuminate\Support\MessageBag
     */
    public function validForUpdate($id, array $data);

    /**
     * Creates or updates the given localization.
     *
     * @param  int $id
     * @param  array $input
     * @return bool|array
     */
    public function store($id, array $input);

    /**
     * Creates a localization entry with the given data.
     *
     * @param  array $data
     * @return \Stevebauman\Localization\Models\Translation
     */
    public function create(array $data);

    /**
     * Updates the localization entry with the given data.
     *
     * @param  int $id
     * @param  array $data
     * @return \Stevebauman\Localization\Models\Translation
     */
    public function update($id, array $data);

    /**
     * Deletes the localization entry.
     *
     * @param  int $id
     * @return bool
     */
    public function delete($id);

}
