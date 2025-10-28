import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../wayfinder'
/**
* @see \App\Http\Controllers\OutfitController::suggest
 * @see app/Http/Controllers/OutfitController.php:22
 * @route '/api/outfit'
 */
export const suggest = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: suggest.url(options),
    method: 'get',
})

suggest.definition = {
    methods: ["get","head"],
    url: '/api/outfit',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\OutfitController::suggest
 * @see app/Http/Controllers/OutfitController.php:22
 * @route '/api/outfit'
 */
suggest.url = (options?: RouteQueryOptions) => {
    return suggest.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\OutfitController::suggest
 * @see app/Http/Controllers/OutfitController.php:22
 * @route '/api/outfit'
 */
suggest.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: suggest.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\OutfitController::suggest
 * @see app/Http/Controllers/OutfitController.php:22
 * @route '/api/outfit'
 */
suggest.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: suggest.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\OutfitController::suggest
 * @see app/Http/Controllers/OutfitController.php:22
 * @route '/api/outfit'
 */
    const suggestForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: suggest.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\OutfitController::suggest
 * @see app/Http/Controllers/OutfitController.php:22
 * @route '/api/outfit'
 */
        suggestForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: suggest.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\OutfitController::suggest
 * @see app/Http/Controllers/OutfitController.php:22
 * @route '/api/outfit'
 */
        suggestForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: suggest.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    suggest.form = suggestForm
const OutfitController = { suggest }

export default OutfitController