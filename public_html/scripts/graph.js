var trace1 = {
    x: ['AB', 'BC', 'MB', 'NB', 'NL', 'NS', 'ON', 'PE', 'QC', 'SK', 'YU'],
    y: [5.764, 4.922, 3.614, 5.668, 3.657, 3.674, 6.182, 3.321, 6.545, 4.722, 2.588],
    type: 'bar',
    text: ['5.764µg/m3', '4.922µg/m3', '3.614µg/m3', '5.668µg/m3', '3.657µg/m3', '3.674µg/m3', '6.182µg/m3', '3.321µg/m3', '6.545µg/m3', '4.722µg/m3', '2.588µg/m3'],
    marker: { color: '#ffcc99' }
};

var data = [trace1];

var layout = {
    title: 'Statistic data of PM2.5 based on National Air Pollution Surveillance (NAPS) Program',
    font: { family: 'Raleway, sans-serif' },
    showlegend: false,
    xaxis: { tickangle: -45 },
    yaxis: {
        zeroline: false,
        gridwidth: 2
    },
    bargap: 0.5
};

Plotly.newPlot('airQuality', data, layout);