import OutfitController from './OutfitController'
import HomeController from './HomeController'
import Settings from './Settings'

const Controllers = {
    OutfitController: Object.assign(OutfitController, OutfitController),
    HomeController: Object.assign(HomeController, HomeController),
    Settings: Object.assign(Settings, Settings),
}

export default Controllers