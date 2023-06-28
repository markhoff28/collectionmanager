<?php

namespace modules\Stock;

use application\AbstractFacade;
use modules\Stock\Plugin\StockPluginPostSafeLocomotive;

/**
 * @method StockFactory getFactory()
 */
class StockFacade extends AbstractFacade
{
    /*
     * TODO: dieses Modul wird KEIN Controller bekommen, denn der Lagerbestand wird im Modul Lock oder Wagon behandelt
     *
     * Der Lagerbestand wird auf der Detailseite der Lock oder des Wagons gesetzt / bearbeitet - Done
     * optional Zusatz: Der Lagerbestand wird in der Übersichtstabelle an die Tabelle hydriert
     *
     * hier werden die stocks von wagon als auch lock gespeichert / behandelt
     *
     * Step2: der stock wird beim zugzusammenbau beachtet - Done
     *
     * beim hinzufügen einer Lok oder eines Wagons wird die anzahl reserviert - Done - sollte die reservierung ein eigenes Modul erhalten?
     * beim Update und Löschen wird die Anzahl ebenso beachtet.
     *
     * zu überlegen: wär es sinnvoll, ein Modul LockStock und ein Modul WagonStock zu bauen und dieses Modul als Basis zu verwenden?
     *
     * optionaler Zusatz: zu überlegen: Reiche ich hier Plugins ein- aus dem LockModul z.B. LockomotiveStockPlugin (beispiel CalculatorOperatorStack) in dieser weise wurde es gemacht
     */

    public function createLocomotiveStockPostSafePlugin() {
        return new StockPluginPostSafeLocomotive();
    }
}
